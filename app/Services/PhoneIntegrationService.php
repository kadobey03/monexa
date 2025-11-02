<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use App\Models\CallLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use Carbon\Carbon;

class PhoneIntegrationService
{
    protected $phoneUtil;
    protected $cachePrefix = 'phone_';
    protected $cacheExpiry = 3600; // 1 hour

    /**
     * Available phone actions.
     */
    protected $availableActions = [
        'call' => [
            'label' => 'Call',
            'icon' => 'phone',
            'color' => 'blue',
            'requires_valid_phone' => true,
        ],
        'whatsapp' => [
            'label' => 'WhatsApp',
            'icon' => 'message-circle',
            'color' => 'green',
            'requires_valid_phone' => true,
        ],
        'sms' => [
            'label' => 'SMS',
            'icon' => 'message-square',
            'color' => 'orange',
            'requires_valid_phone' => true,
        ],
        'copy' => [
            'label' => 'Copy',
            'icon' => 'copy',
            'color' => 'gray',
            'requires_valid_phone' => false,
        ],
    ];

    public function __construct()
    {
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    /**
     * Validate and format phone number.
     */
    public function validateAndFormatPhone(string $phone, string $defaultCountry = 'US'): array
    {
        $cacheKey = $this->cachePrefix . 'format_' . md5($phone . $defaultCountry);
        
        return Cache::remember($cacheKey, $this->cacheExpiry, function() use ($phone, $defaultCountry) {
            try {
                // Parse the phone number
                $phoneNumber = $this->phoneUtil->parse($phone, $defaultCountry);
                
                // Check if valid
                $isValid = $this->phoneUtil->isValidNumber($phoneNumber);
                
                if (!$isValid) {
                    return [
                        'is_valid' => false,
                        'original' => $phone,
                        'error' => 'Invalid phone number format',
                    ];
                }

                // Get various formats
                $formats = [
                    'international' => $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::INTERNATIONAL),
                    'national' => $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::NATIONAL),
                    'e164' => $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::E164),
                    'rfc3966' => $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::RFC3966),
                ];

                // Get country info
                $countryCode = $this->phoneUtil->getRegionCodeForNumber($phoneNumber);
                $countryCallingCode = $phoneNumber->getCountryCode();

                // Get number type
                $numberType = $this->phoneUtil->getNumberType($phoneNumber);
                $numberTypeString = $this->getNumberTypeString($numberType);

                return [
                    'is_valid' => true,
                    'original' => $phone,
                    'formats' => $formats,
                    'country_code' => $countryCode,
                    'country_calling_code' => $countryCallingCode,
                    'number_type' => $numberTypeString,
                    'can_call' => in_array($numberTypeString, ['MOBILE', 'FIXED_LINE', 'FIXED_LINE_OR_MOBILE']),
                    'can_whatsapp' => in_array($numberTypeString, ['MOBILE', 'FIXED_LINE_OR_MOBILE']),
                    'can_sms' => in_array($numberTypeString, ['MOBILE', 'FIXED_LINE_OR_MOBILE']),
                ];

            } catch (NumberParseException $e) {
                return [
                    'is_valid' => false,
                    'original' => $phone,
                    'error' => $e->getMessage(),
                    'error_code' => $e->getErrorType(),
                ];
            }
        });
    }

    /**
     * Get phone actions for a lead.
     */
    public function getPhoneActions(User $lead, Admin $admin): array
    {
        if (empty($lead->phone)) {
            return [];
        }

        $phoneData = $this->validateAndFormatPhone($lead->phone, $lead->country ?? 'US');
        
        if (!$phoneData['is_valid']) {
            return [[
                'action' => 'copy',
                'label' => 'Copy (Invalid)',
                'icon' => 'copy',
                'color' => 'red',
                'phone' => $lead->phone,
                'disabled' => false,
            ]];
        }

        $actions = [];
        
        foreach ($this->availableActions as $actionKey => $actionConfig) {
            // Check if action is available for this phone type
            if ($actionConfig['requires_valid_phone']) {
                if (!$phoneData['is_valid']) {
                    continue;
                }
                
                // Check specific capabilities
                switch ($actionKey) {
                    case 'call':
                        if (!($phoneData['can_call'] ?? false)) continue 2;
                        break;
                    case 'whatsapp':
                        if (!($phoneData['can_whatsapp'] ?? false)) continue 2;
                        break;
                    case 'sms':
                        if (!($phoneData['can_sms'] ?? false)) continue 2;
                        break;
                }
            }

            // Check admin permissions
            if (!$this->canPerformAction($admin, $actionKey, $lead)) {
                continue;
            }

            $actions[] = [
                'action' => $actionKey,
                'label' => $actionConfig['label'],
                'icon' => $actionConfig['icon'],
                'color' => $actionConfig['color'],
                'phone' => $phoneData['formats']['e164'] ?? $lead->phone,
                'formatted_phone' => $phoneData['formats']['international'] ?? $lead->phone,
                'disabled' => false,
            ];
        }

        return $actions;
    }

    /**
     * Check if admin can perform phone action.
     */
    protected function canPerformAction(Admin $admin, string $action, User $lead): bool
    {
        // Basic permission check - can user view this lead?
        $authService = app(LeadAuthorizationService::class);
        if (!$authService->canViewLead($admin, $lead)) {
            return false;
        }

        switch ($action) {
            case 'copy':
                return true; // Anyone can copy if they can view

            case 'call':
            case 'whatsapp':
            case 'sms':
                // Check if admin has communication permissions
                return $this->hasCommuncationPermissions($admin);

            default:
                return false;
        }
    }

    /**
     * Check if admin has communication permissions.
     */
    protected function hasCommuncationPermissions(Admin $admin): bool
    {
        $restrictedRoles = ['viewer', 'analyst']; // Add roles that can't make calls
        $roleName = $admin->role?->name;
        
        return !in_array($roleName, $restrictedRoles);
    }

    /**
     * Initiate a call and log it.
     */
    public function initiateCall(Admin $admin, User $lead, array $options = []): array
    {
        try {
            // Validate permissions
            if (!$this->canPerformAction($admin, 'call', $lead)) {
                return [
                    'success' => false,
                    'error' => 'You do not have permission to make calls to this lead.',
                ];
            }

            // Validate phone number
            $phoneData = $this->validateAndFormatPhone($lead->phone, $lead->country ?? 'US');
            if (!$phoneData['is_valid']) {
                return [
                    'success' => false,
                    'error' => 'Invalid phone number: ' . $lead->phone,
                ];
            }

            // Create call log
            $callLog = CallLog::create([
                'admin_id' => $admin->id,
                'lead_id' => $lead->id,
                'phone_number' => $phoneData['formats']['e164'],
                'formatted_phone' => $phoneData['formats']['international'],
                'call_type' => 'outbound',
                'call_status' => 'initiated',
                'initiated_at' => now(),
                'call_method' => $options['method'] ?? 'click_to_call',
                'notes' => $options['notes'] ?? null,
            ]);

            // Integrate with phone system (placeholder - implement based on your system)
            $callResult = $this->makeSystemCall($admin, $phoneData, $callLog, $options);

            if ($callResult['success']) {
                $callLog->update([
                    'call_status' => 'in_progress',
                    'external_call_id' => $callResult['call_id'] ?? null,
                    'started_at' => now(),
                ]);

                // Update lead's last contact
                $lead->update([
                    'last_contact_date' => now(),
                    'last_contact_admin_id' => $admin->id,
                    'last_contact_type' => 'call',
                ]);

                Log::info('Call initiated successfully', [
                    'admin_id' => $admin->id,
                    'lead_id' => $lead->id,
                    'call_log_id' => $callLog->id,
                    'phone' => $phoneData['formats']['e164'],
                ]);

                return [
                    'success' => true,
                    'call_log_id' => $callLog->id,
                    'message' => 'Call initiated successfully',
                    'phone' => $phoneData['formats']['international'],
                ];
            } else {
                $callLog->update([
                    'call_status' => 'failed',
                    'ended_at' => now(),
                    'failure_reason' => $callResult['error'],
                ]);

                return [
                    'success' => false,
                    'error' => $callResult['error'],
                ];
            }

        } catch (\Exception $e) {
            Log::error('Call initiation failed', [
                'admin_id' => $admin->id,
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Failed to initiate call: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Generate WhatsApp link.
     */
    public function generateWhatsAppLink(User $lead, string $message = null): array
    {
        $phoneData = $this->validateAndFormatPhone($lead->phone, $lead->country ?? 'US');
        
        if (!$phoneData['is_valid']) {
            return [
                'success' => false,
                'error' => 'Invalid phone number for WhatsApp',
            ];
        }

        if (!($phoneData['can_whatsapp'] ?? false)) {
            return [
                'success' => false,
                'error' => 'Phone number not suitable for WhatsApp',
            ];
        }

        // Clean phone number (remove + and spaces)
        $cleanPhone = str_replace(['+', ' ', '-', '(', ')'], '', $phoneData['formats']['e164']);

        // Default message template
        if (empty($message)) {
            $message = "Hello {$lead->name}, this is " . auth('admin')->user()->getFullName() . " from " . config('app.name', 'Our Company') . ". How can I help you today?";
        }

        // Generate WhatsApp URL
        $whatsappUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode($message);

        return [
            'success' => true,
            'url' => $whatsappUrl,
            'phone' => $phoneData['formats']['international'],
            'message' => $message,
        ];
    }

    /**
     * Update call status.
     */
    public function updateCallStatus(int $callLogId, string $status, array $data = []): bool
    {
        try {
            $callLog = CallLog::findOrFail($callLogId);
            
            $updateData = ['call_status' => $status];
            
            switch ($status) {
                case 'answered':
                    $updateData['answered_at'] = now();
                    break;
                case 'completed':
                    $updateData['ended_at'] = now();
                    if (isset($data['duration'])) {
                        $updateData['duration_seconds'] = $data['duration'];
                    }
                    break;
                case 'failed':
                case 'no_answer':
                case 'busy':
                    $updateData['ended_at'] = now();
                    if (isset($data['reason'])) {
                        $updateData['failure_reason'] = $data['reason'];
                    }
                    break;
            }

            if (isset($data['notes'])) {
                $updateData['notes'] = $data['notes'];
            }

            if (isset($data['recording_url'])) {
                $updateData['recording_url'] = $data['recording_url'];
            }

            $callLog->update($updateData);

            Log::info('Call status updated', [
                'call_log_id' => $callLogId,
                'status' => $status,
                'data' => $data,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to update call status', [
                'call_log_id' => $callLogId,
                'status' => $status,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Get call history for lead.
     */
    public function getCallHistory(User $lead, int $limit = 10): array
    {
        $calls = CallLog::where('lead_id', $lead->id)
            ->with('admin:id,firstName,lastName')
            ->orderBy('initiated_at', 'desc')
            ->limit($limit)
            ->get();

        return $calls->map(function($call) {
            return [
                'id' => $call->id,
                'admin_name' => $call->admin->getFullName(),
                'phone_number' => $call->formatted_phone,
                'call_type' => $call->call_type,
                'call_status' => $call->call_status,
                'duration' => $call->duration_seconds ? $this->formatDuration($call->duration_seconds) : null,
                'initiated_at' => $call->initiated_at,
                'ended_at' => $call->ended_at,
                'notes' => $call->notes,
                'recording_url' => $call->recording_url,
            ];
        })->toArray();
    }

    /**
     * Get call statistics for admin.
     */
    public function getCallStatistics(Admin $admin, string $period = '30_days'): array
    {
        $startDate = $this->getStartDateForPeriod($period);
        
        $query = CallLog::where('admin_id', $admin->id)
            ->where('initiated_at', '>=', $startDate);

        return [
            'total_calls' => $query->count(),
            'completed_calls' => $query->where('call_status', 'completed')->count(),
            'answered_calls' => $query->whereIn('call_status', ['answered', 'completed'])->count(),
            'failed_calls' => $query->where('call_status', 'failed')->count(),
            'no_answer_calls' => $query->where('call_status', 'no_answer')->count(),
            'total_duration' => $query->sum('duration_seconds'),
            'average_duration' => $query->where('call_status', 'completed')->avg('duration_seconds'),
            'unique_leads_contacted' => $query->distinct('lead_id')->count('lead_id'),
        ];
    }

    /**
     * Make system call (integrate with your phone system).
     */
    protected function makeSystemCall(Admin $admin, array $phoneData, CallLog $callLog, array $options): array
    {
        // This is a placeholder - implement based on your phone system
        // Examples: Twilio, RingCentral, Asterisk, etc.
        
        $phoneSystem = config('phone.system', 'mock');
        
        switch ($phoneSystem) {
            case 'twilio':
                return $this->makeTwilioCall($admin, $phoneData, $callLog, $options);
            
            case 'ringcentral':
                return $this->makeRingCentralCall($admin, $phoneData, $callLog, $options);
            
            case 'asterisk':
                return $this->makeAsteriskCall($admin, $phoneData, $callLog, $options);
            
            default:
                // Mock success for testing
                return [
                    'success' => true,
                    'call_id' => 'mock_' . uniqid(),
                    'message' => 'Mock call initiated',
                ];
        }
    }

    /**
     * Placeholder for Twilio integration.
     */
    protected function makeTwilioCall(Admin $admin, array $phoneData, CallLog $callLog, array $options): array
    {
        // Implement Twilio API integration
        return ['success' => false, 'error' => 'Twilio integration not implemented'];
    }

    /**
     * Placeholder for RingCentral integration.
     */
    protected function makeRingCentralCall(Admin $admin, array $phoneData, CallLog $callLog, array $options): array
    {
        // Implement RingCentral API integration
        return ['success' => false, 'error' => 'RingCentral integration not implemented'];
    }

    /**
     * Placeholder for Asterisk integration.
     */
    protected function makeAsteriskCall(Admin $admin, array $phoneData, CallLog $callLog, array $options): array
    {
        // Implement Asterisk AMI integration
        return ['success' => false, 'error' => 'Asterisk integration not implemented'];
    }

    /**
     * Get number type as string.
     */
    protected function getNumberTypeString(int $numberType): string
    {
        $types = [
            0 => 'FIXED_LINE',
            1 => 'MOBILE',
            2 => 'FIXED_LINE_OR_MOBILE',
            3 => 'TOLL_FREE',
            4 => 'PREMIUM_RATE',
            5 => 'SHARED_COST',
            6 => 'VOIP',
            7 => 'PERSONAL_NUMBER',
            8 => 'PAGER',
            9 => 'UAN',
            10 => 'VOICEMAIL',
            -1 => 'UNKNOWN',
        ];

        return $types[$numberType] ?? 'UNKNOWN';
    }

    /**
     * Format duration in human readable format.
     */
    protected function formatDuration(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . 's';
        }
        
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        
        if ($minutes < 60) {
            return $minutes . 'm ' . $remainingSeconds . 's';
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        return $hours . 'h ' . $remainingMinutes . 'm ' . $remainingSeconds . 's';
    }

    /**
     * Get start date for period.
     */
    protected function getStartDateForPeriod(string $period): Carbon
    {
        switch ($period) {
            case 'today':
                return now()->startOfDay();
            case '7_days':
                return now()->subDays(7);
            case '30_days':
                return now()->subDays(30);
            case '90_days':
                return now()->subDays(90);
            case 'this_month':
                return now()->startOfMonth();
            case 'last_month':
                return now()->subMonth()->startOfMonth();
            default:
                return now()->subDays(30);
        }
    }

    /**
     * Clear phone cache.
     */
    public function clearCache(string $phone = null): void
    {
        if ($phone) {
            $keys = [
                $this->cachePrefix . 'format_' . md5($phone . 'US'),
                $this->cachePrefix . 'format_' . md5($phone . 'TR'),
            ];
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        } else {
            // Clear all phone cache (use with caution)
            Cache::flush(); // This clears all cache - implement more specific clearing if needed
        }
    }
}