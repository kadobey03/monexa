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
        $this->error = $errorData['message'] ?? 'An error occurred';
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
            $this->addError('maxRetries', 'Maximum retry attempts reached');
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
                'tr' => ['İnternet bağlantınızı kontrol edin', 'Sayfayı yenilemeyi deneyin'],
                'en' => ['Check your internet connection', 'Try refreshing the page']
            ],
            'financial' => [
                'tr' => ['Bakiyenizi kontrol edin', 'Farklı bir ödeme yöntemi deneyin'],
                'en' => ['Check your balance', 'Try a different payment method']
            ],
            'authentication' => [
                'tr' => ['Tekrar giriş yapmayı deneyin', 'Parolanızı sıfırlayın'],
                'en' => ['Try logging in again', 'Reset your password']
            ],
            'validation' => [
                'tr' => ['Form bilgilerinizi kontrol edin', 'Gerekli alanları doldurun'],
                'en' => ['Check your form information', 'Fill in required fields']
            ],
            default => [
                'tr' => ['Sayfayı yenileyin', 'Destek ekibi ile iletişime geçin'],
                'en' => ['Refresh the page', 'Contact support team']
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