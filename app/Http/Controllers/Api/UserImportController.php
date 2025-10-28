<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class UserImportController extends Controller
{
    /**
     * Import users endpoint
     * POST /api/import/users
     */
    public function importUser(Request $request): JsonResponse
    {
        // Simple header authentication check
        if ($request->header('Authorization') !== 'Bearer 41|8ezkQw7SGjTfnnLjGSDfXmTNtcy5psTLbFv1s6wMf85f472c') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid token'
            ], 401);
        }
        
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'fa2' => 'nullable|boolean',
                'age' => 'nullable|integer|min:18|max:120',
                'additional_info' => 'nullable|string|max:1000',
                'country' => 'nullable|string|max:100',
                'region' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
                'address' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|max:20',
                'utm_source' => 'nullable|string|max:100',
                'utm_medium' => 'nullable|string|max:100',
                'utm_campaign' => 'nullable|string|max:100',
                'utm_content' => 'nullable|string|max:255',
                'utm_term' => 'nullable|string|max:100',
                'comment' => 'nullable|string|max:1000',
                'domain' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();
            
            // Generate username from email
            $username = $this->generateUsername($data['email']);
            
            // Get settings for referral link
            $settings = Settings::first();
            
            // Create UTM source string
            $utmData = [];
            if (!empty($data['utm_source'])) $utmData[] = 'source:' . $data['utm_source'];
            if (!empty($data['utm_medium'])) $utmData[] = 'medium:' . $data['utm_medium'];
            if (!empty($data['utm_campaign'])) $utmData[] = 'campaign:' . $data['utm_campaign'];
            if (!empty($data['utm_content'])) $utmData[] = 'content:' . $data['utm_content'];
            if (!empty($data['utm_term'])) $utmData[] = 'term:' . $data['utm_term'];
            
            $leadSource = !empty($utmData) ? implode(', ', $utmData) : 'API Import';
            
            // Create additional info JSON for notify field
            $additionalInfo = [
                'utm_source' => $data['utm_source'] ?? null,
                'utm_medium' => $data['utm_medium'] ?? null,
                'utm_campaign' => $data['utm_campaign'] ?? null,
                'utm_content' => $data['utm_content'] ?? null,
                'utm_term' => $data['utm_term'] ?? null,
                'domain' => $data['domain'] ?? null,
                'additional_info' => $data['additional_info'] ?? null,
                'age' => $data['age'] ?? null,
                'fa2' => $data['fa2'] ?? false,
                'lead_source' => $leadSource,
                'import_date' => now()->toISOString(),
                'region' => $data['region'] ?? null,
                'city' => $data['city'] ?? null,
                'zip_code' => $data['zip_code'] ?? null
            ];

            // Prepare user data for existing table structure
            $userData = [
                'name' => $data['first_name'] . ' ' . ($data['last_name'] ?? ''),
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'country' => $data['country'] ?? null,
                'address' => trim(($data['address'] ?? '') . ' ' . ($data['city'] ?? '') . ' ' . ($data['region'] ?? '') . ' ' . ($data['zip_code'] ?? '')),
                'password' => Hash::make($data['password']),
                'username' => $username,
                'status' => 'active',
                'currency' => 'USD',
                's_currency' => 'USD',
                'account_bal' => 0,
                'demo_balance' => 0,
                'roi' => 0,
                'bonus' => 0,
                'ref_bonus' => 0,
                'cstatus' => 'Lead',
                'notify' => json_encode($additionalInfo),
                'userupdate' => $data['comment'] ?? null,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Create user
            $user = User::create($userData);
            
            // Generate referral link
            if ($settings && $settings->site_address) {
                $user->update([
                    'ref_link' => $settings->site_address . '/ref/' . $user->username
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'User imported successfully',
                'data' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                    'name' => $user->name,
                    'status' => $user->cstatus,
                    'ref_link' => $user->ref_link,
                    'additional_info' => json_decode($user->notify ?? '{}', true),
                    'created_at' => $user->created_at->toISOString()
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User import failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique username from email
     */
    private function generateUsername(string $email): string
    {
        $baseUsername = substr($email, 0, strpos($email, '@'));
        $username = $baseUsername;
        $counter = 1;
        
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        return $username;
    }

    /**
     * Bulk import users endpoint
     * POST /api/import/users/bulk
     */
    public function bulkImportUsers(Request $request): JsonResponse
    {
        // Simple header authentication check
        if ($request->header('Authorization') !== 'Bearer 41|8ezkQw7SGjTfnnLjGSDfXmTNtcy5psTLbFv1s6wMf85f472c') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid token'
            ], 401);
        }
        
        try {
            $validator = Validator::make($request->all(), [
                'users' => 'required|array|min:1|max:100',
                'users.*.email' => 'required|email',
                'users.*.password' => 'required|min:6',
                'users.*.first_name' => 'required|string|max:255',
                'users.*.last_name' => 'nullable|string|max:255',
                'users.*.phone' => 'nullable|string|max:20',
                'users.*.country' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $users = $validator->validated()['users'];
            $results = [
                'success' => [],
                'failed' => [],
                'duplicates' => []
            ];

            foreach ($users as $index => $userData) {
                try {
                    // Check if user already exists
                    if (User::where('email', $userData['email'])->exists()) {
                        $results['duplicates'][] = [
                            'index' => $index,
                            'email' => $userData['email'],
                            'reason' => 'User with this email already exists'
                        ];
                        continue;
                    }

                    // Import single user
                    $request = new Request($userData);
                    $response = $this->importUser($request);
                    
                    if ($response->getStatusCode() === 201) {
                        $responseData = json_decode($response->getContent(), true);
                        $results['success'][] = [
                            'index' => $index,
                            'user_id' => $responseData['data']['user_id'],
                            'email' => $userData['email']
                        ];
                    } else {
                        $responseData = json_decode($response->getContent(), true);
                        $results['failed'][] = [
                            'index' => $index,
                            'email' => $userData['email'],
                            'reason' => $responseData['message'] ?? 'Unknown error'
                        ];
                    }
                } catch (\Exception $e) {
                    $results['failed'][] = [
                        'index' => $index,
                        'email' => $userData['email'],
                        'reason' => $e->getMessage()
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Bulk import completed',
                'results' => $results,
                'summary' => [
                    'total' => count($users),
                    'successful' => count($results['success']),
                    'failed' => count($results['failed']),
                    'duplicates' => count($results['duplicates'])
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk import failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}