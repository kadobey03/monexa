<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ErrorBoundary extends Component
{
    public $error;
    public $errorInfo;
    public $hasError = false;
    public $retryCount = 0;
    public $maxRetries = 3;
    
    protected $listeners = [
        'errorOccurred' => 'handleError',
        'retry' => 'retryOperation',
        'reset' => 'resetError'
    ];

    public function mount($initialError = null)
    {
        if ($initialError) {
            $this->handleError($initialError);
        }
    }

    public function handleError($errorData)
    {
        $this->hasError = true;
        $this->error = $errorData['message'] ?? __('livewire.error_boundary.general_error');
        $this->errorInfo = $errorData;
        
        // Log error for monitoring
        $this->logError($errorData);
        
        // Emit event to parent components
        $this->emit('errorHandled', [
            'error' => $this->error,
            'errorInfo' => $this->errorInfo
        ]);
    }

    public function retryOperation()
    {
        if ($this->retryCount >= $this->maxRetries) {
            $this->addError('maxRetries', __('livewire.error_boundary.max_retries_reached'));
            return;
        }

        $this->retryCount++;
        
        // Emit retry event to parent component
        $this->emit('retry', [
            'retryCount' => $this->retryCount,
            'error' => $this->error
        ]);
    }

    public function resetError()
    {
        $this->hasError = false;
        $this->error = null;
        $this->errorInfo = null;
        $this->retryCount = 0;
        $this->resetErrorBag();
        
        $this->emit('errorReset');
    }

    public function getErrorTypeProperty()
    {
        if (!$this->hasError || !$this->errorInfo) {
            return 'unknown';
        }

        $errorInfo = $this->errorInfo;
        
        if (isset($errorInfo['type'])) {
            return $errorInfo['type'];
        }
        
        if (str_contains(strtolower($this->error), 'network')) {
            return 'network';
        }
        
        if (str_contains(strtolower($this->error), 'financial')) {
            return 'financial';
        }
        
        if (str_contains(strtolower($this->error), 'auth')) {
            return 'authentication';
        }
        
        return 'general';
    }

    public function getErrorSuggestionsProperty()
    {
        $errorType = $this->errorType;
        
        return match($errorType) {
            'network' => [
                'tr' => [__('livewire.error_boundary.check_internet_connection'), __('livewire.error_boundary.try_refresh_page')],
                'en' => [__('livewire.error_boundary.check_internet_connection'), __('livewire.error_boundary.try_refresh_page')]
            ],
            'financial' => [
                'tr' => [__('livewire.error_boundary.check_balance'), __('livewire.error_boundary.try_different_payment')],
                'en' => [__('livewire.error_boundary.check_balance'), __('livewire.error_boundary.try_different_payment')]
            ],
            'authentication' => [
                'tr' => [__('livewire.error_boundary.try_login_again'), __('livewire.error_boundary.reset_password')],
                'en' => [__('livewire.error_boundary.try_login_again'), __('livewire.error_boundary.reset_password')]
            ],
            'validation' => [
                'tr' => [__('livewire.error_boundary.check_form_info'), __('livewire.error_boundary.fill_required_fields')],
                'en' => [__('livewire.error_boundary.check_form_info'), __('livewire.error_boundary.fill_required_fields')]
            ],
            default => [
                'tr' => [__('livewire.error_boundary.refresh_page'), __('livewire.error_boundary.contact_support')],
                'en' => [__('livewire.error_boundary.refresh_page'), __('livewire.error_boundary.contact_support')]
            ]
        };
    }

    public function render()
    {
        if ($this->hasError) {
            return view('livewire.error-boundary.error-display');
        }

        return $this->slot ?? view('livewire.error-boundary.default-slot');
    }

    private function logError($errorData)
    {
        // This would integrate with your error logging service
        \Log::error('Livewire Error Boundary', [
            'error' => $errorData,
            'component' => class_basename($this),
            'retry_count' => $this->retryCount,
            'timestamp' => now(),
        ]);
    }
}