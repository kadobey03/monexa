<?php

namespace App\Imports;

use App\Models\User;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithChunkReading, WithBatchInserts
{
    use SkipsFailures;
    
    protected $importStats = [
        'imported' => 0,
        'skipped' => 0,
        'errors' => []
    ];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip if email already exists
        if (User::where('email', $row['email'])->exists()) {
            $this->importStats['skipped']++;
            return null;
        }

        // Generate random password
        $randomPassword = $this->generateRandomPassword();
        
        // Get default "new" lead status
        $newLeadStatus = LeadStatus::where('name', 'new')->first();
        
        // Generate username if not provided
        $username = $row['username'] ?? $this->generateUsername($row['name'], $row['email']);

        $user = new User([
            'name' => $this->cleanName($row['name']),
            'email' => strtolower(trim($row['email'])),
            'password' => Hash::make($randomPassword),
            'email_verified_at' => now(),
            'username' => $username,
            'country' => $row['country'] ?? null,
            'phone' => $this->cleanPhone($row['phone_number'] ?? $row['phone'] ?? null),
            'status' => 'active', // Set as active by default
            'lead_source' => 'import',
            'lead_status' => $newLeadStatus ? $newLeadStatus->name : 'new',
            'lead_score' => 10, // Base score for imported leads
            'lead_notes' => 'Excel dosyasından içe aktarıldı: ' . now()->format('d.m.Y H:i'),
            'lead_tags' => ['imported', 'excel'],
            'estimated_value' => $row['estimated_value'] ?? null,
            'preferred_contact_method' => $this->determinePreferredContact($row),
            'contact_history' => [[
                'type' => 'import',
                'note' => 'Lead Excel dosyasından içe aktarıldı',
                'admin_id' => auth('admin')->id(),
                'created_at' => now()->toISOString(),
            ]],
        ]);

        $this->importStats['imported']++;
        
        return $user;
    }

    /**
     * Validation rules for import
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'username' => 'nullable|string|max:255|unique:users,username',
            'estimated_value' => 'nullable|numeric|min:0'
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'name.required' => 'İsim alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'email.unique' => 'Bu e-posta adresi zaten sistemde kayıtlı.',
            'username.unique' => 'Bu kullanıcı adı zaten kullanılıyor.',
        ];
    }

    /**
     * Chunk size for processing
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Batch size for inserts
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Clean and format name
     */
    private function cleanName($name)
    {
        return trim(ucwords(strtolower($name)));
    }

    /**
     * Clean and format phone number
     */
    private function cleanPhone($phone)
    {
        if (!$phone) return null;
        
        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Add country code if missing (assuming Turkey +90)
        if (strlen($phone) == 10 && !str_starts_with($phone, '+')) {
            $phone = '+90' . $phone;
        }
        
        return $phone;
    }

    /**
     * Generate username from name and email
     */
    private function generateUsername($name, $email)
    {
        $emailPrefix = explode('@', $email)[0];
        $baseUsername = strtolower(Str::slug($name . '_' . $emailPrefix, '_'));
        
        // Ensure uniqueness
        $username = $baseUsername;
        $counter = 1;
        
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter;
            $counter++;
        }
        
        return $username;
    }

    /**
     * Generate random password
     */
    private function generateRandomPassword()
    {
        return Str::random(8) . rand(10, 99); // 8 chars + 2 numbers
    }

    /**
     * Determine preferred contact method
     */
    private function determinePreferredContact($row)
    {
        // If phone exists, prefer phone, otherwise email
        if (!empty($row['phone_number']) || !empty($row['phone'])) {
            return 'phone';
        }
        return 'email';
    }

    /**
     * Get import statistics
     */
    public function getImportStats()
    {
        return $this->importStats;
    }

    /**
     * Handle failed rows
     */
    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->importStats['errors'][] = [
                'row' => $failure->row(),
                'errors' => $failure->errors()
            ];
            $this->importStats['skipped']++;
        }
    }
}