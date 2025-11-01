<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
 * Unified API Client Service
 * Standardizes all external API communications across the platform
 */
class ApiClientService
{
    private Client $httpClient;
    
    public function __construct()
    {
        $this->httpClient = new Client([
            'timeout' => 30,
            'connect_timeout' => 10,
            'http_errors' => false,
            'verify' => env('VERIFY_SSL_CERTIFICATES', true),
            'headers' => [
                'User-Agent' => 'MonexaFinans/1.0.0',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * Make HTTP GET request with standard error handling
     */
    public function get(string $url, array $headers = [], array $query = []): array
    {
        try {
            $options = [];
            
            if (!empty($query)) {
                $options['query'] = $query;
            }
            
            if (!empty($headers)) {
                $options['headers'] = $headers;
            }

            $response = $this->httpClient->get($url, $options);
            
            return $this->processResponse($response, 'GET', $url);
            
        } catch (ConnectException $e) {
            Log::error('API Connection failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Connection failed', 0, $e->getMessage());
            
        } catch (RequestException $e) {
            Log::error('API Request failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Request failed', $e->getCode(), $e->getMessage());
        }
    }

    /**
     * Make HTTP POST request with standard error handling
     */
    public function post(string $url, array $data = [], array $headers = []): array
    {
        try {
            $options = ['json' => $data];
            
            if (!empty($headers)) {
                $options['headers'] = $headers;
            }

            $response = $this->httpClient->post($url, $options);
            
            return $this->processResponse($response, 'POST', $url);
            
        } catch (ConnectException $e) {
            Log::error('API Connection failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Connection failed', 0, $e->getMessage());
            
        } catch (RequestException $e) {
            Log::error('API Request failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Request failed', $e->getCode(), $e->getMessage());
        }
    }

    /**
     * Make HTTP PUT request with standard error handling
     */
    public function put(string $url, array $data = [], array $headers = []): array
    {
        try {
            $options = ['json' => $data];
            
            if (!empty($headers)) {
                $options['headers'] = $headers;
            }

            $response = $this->httpClient->put($url, $options);
            
            return $this->processResponse($response, 'PUT', $url);
            
        } catch (ConnectException $e) {
            Log::error('API Connection failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Connection failed', 0, $e->getMessage());
            
        } catch (RequestException $e) {
            Log::error('API Request failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Request failed', $e->getCode(), $e->getMessage());
        }
    }

    /**
     * Make HTTP DELETE request with standard error handling
     */
    public function delete(string $url, array $headers = []): array
    {
        try {
            $options = [];
            
            if (!empty($headers)) {
                $options['headers'] = $headers;
            }

            $response = $this->httpClient->delete($url, $options);
            
            return $this->processResponse($response, 'DELETE', $url);
            
        } catch (ConnectException $e) {
            Log::error('API Connection failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Connection failed', 0, $e->getMessage());
            
        } catch (RequestException $e) {
            Log::error('API Request failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Request failed', $e->getCode(), $e->getMessage());
        }
    }

    /**
     * Process HTTP response with standard formatting
     */
    private function processResponse($response, string $method, string $url): array
    {
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        
        // Log API call
        Log::info('API Call completed', [
            'method' => $method,
            'url' => $url,
            'status_code' => $statusCode,
            'timestamp' => now()->toISOString()
        ]);

        // Attempt to parse JSON
        $data = null;
        $parseError = false;
        
        if (!empty($body)) {
            try {
                $data = json_decode($body, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $data = $body;
                    $parseError = true;
                }
            } catch (\Exception $e) {
                $data = $body;
                $parseError = true;
            }
        }

        return [
            'success' => $statusCode >= 200 && $statusCode < 300,
            'status_code' => $statusCode,
            'data' => $data,
            'body' => $body,
            'method' => $method,
            'url' => $url,
            'timestamp' => now()->toISOString(),
            'parse_error' => $parseError
        ];
    }

    /**
     * Standard error response format
     */
    private function errorResponse(string $message, int $statusCode, string $error = null): array
    {
        return [
            'success' => false,
            'status_code' => $statusCode,
            'data' => null,
            'error' => $message,
            'error_detail' => $error,
            'timestamp' => now()->toISOString()
        ];
    }

    /**
     * Fetch cryptocurrency prices from CoinGecko (replacing direct fetch calls)
     */
    public function getCryptoPrices(array $coins = ['bitcoin', 'ethereum']): array
    {
        $url = 'https://api.coingecko.com/api/v3/simple/price';
        $query = [
            'ids' => implode(',', $coins),
            'vs_currencies' => 'usd',
            'include_24hr_change' => 'true'
        ];

        $response = $this->get($url, [], $query);
        
        if ($response['success']) {
            Log::info('Crypto prices fetched successfully', [
                'coins' => $coins,
                'timestamp' => now()->toISOString()
            ]);
        }

        return $response;
    }

    /**
     * Get forex rates from ExchangeRate API (replacing direct fetch calls)
     */
    public function getForexRates(string $baseCurrency = 'USD', array $symbols = ['EUR', 'GBP', 'JPY']): array
    {
        $url = 'https://api.exchangerate.host/latest';
        $query = [
            'base' => $baseCurrency,
            'symbols' => implode(',', $symbols)
        ];

        return $this->get($url, [], $query);
    }

    /**
     * Generic webhook handler for payment providers
     */
    public function processWebhook(string $provider, array $payload, string $secretKey): array
    {
        try {
            // Verify webhook signature based on provider
            $isValidSignature = $this->verifyWebhookSignature($provider, $payload, $secretKey);
            
            if (!$isValidSignature) {
                return $this->errorResponse('Invalid webhook signature', 401);
            }

            // Process webhook based on provider
            $result = $this->handleProviderWebhook($provider, $payload);
            
            Log::info('Webhook processed', [
                'provider' => $provider,
                'success' => $result['success']
            ]);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'provider' => $provider,
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Webhook processing failed', 500, $e->getMessage());
        }
    }

    /**
     * Verify webhook signature for different providers
     */
    private function verifyWebhookSignature(string $provider, array $payload, string $secretKey): bool
    {
        switch (strtolower($provider)) {
            case 'paystack':
                return $this->verifyPaystackSignature($payload, $secretKey);
                
            case 'flutterwave':
                return $this->verifyFlutterwaveSignature($payload, $secretKey);
                
            case 'stripe':
                return $this->verifyStripeSignature($payload, $secretKey);
                
            default:
                Log::warning('Unknown webhook provider', ['provider' => $provider]);
                return false;
        }
    }

    /**
     * Verify Paystack webhook signature
     */
    private function verifyPaystackSignature(array $payload, string $secretKey): bool
    {
        $signature = request()->header('x-paystack-signature');
        $hash = hash_hmac('sha512', request()->getContent(), $secretKey);
        
        return hash_equals($hash, $signature);
    }

    /**
     * Verify Flutterwave webhook signature
     */
    private function verifyFlutterwaveSignature(array $payload, string $secretKey): bool
    {
        $signature = request()->header('verif-hash');
        return hash_equals($signature, $secretKey);
    }

    /**
     * Verify Stripe webhook signature
     */
    private function verifyStripeSignature(array $payload, string $secretKey): bool
    {
        $timestamp = time();
        $signedPayload = $timestamp . '.' . request()->getContent();
        $expectedSignature = hash_hmac('sha256', $signedPayload, $secretKey);
        
        $actualSignature = request()->header('stripe-signature');
        
        return hash_equals($expectedSignature, $actualSignature);
    }

    /**
     * Handle provider-specific webhook processing
     */
    private function handleProviderWebhook(string $provider, array $payload): array
    {
        switch (strtolower($provider)) {
            case 'paystack':
                return $this->processPaystackWebhook($payload);
                
            case 'flutterwave':
                return $this->processFlutterwaveWebhook($payload);
                
            case 'stripe':
                return $this->processStripeWebhook($payload);
                
            default:
                return $this->errorResponse('Unsupported provider', 400);
        }
    }

    /**
     * Process Paystack webhook
     */
    private function processPaystackWebhook(array $payload): array
    {
        // Paystack webhook processing logic
        // This would integrate with your existing PaystackController logic
        return ['success' => true, 'message' => 'Paystack webhook processed'];
    }

    /**
     * Process Flutterwave webhook
     */
    private function processFlutterwaveWebhook(array $payload): array
    {
        // Flutterwave webhook processing logic
        // This would integrate with your existing FlutterwaveController logic
        return ['success' => true, 'message' => 'Flutterwave webhook processed'];
    }

    /**
     * Process Stripe webhook
     */
    private function processStripeWebhook(array $payload): array
    {
        // Stripe webhook processing logic
        return ['success' => true, 'message' => 'Stripe webhook processed'];
    }

    /**
     * Get current exchange rates for dashboard display
     */
    public function getDashboardExchangeRates(): array
    {
        try {
            // Get crypto prices
            $cryptoRates = $this->getCryptoPrices(['bitcoin', 'ethereum']);
            
            // Get forex rates
            $forexRates = $this->getForexRates('USD', ['EUR', 'GBP', 'JPY']);
            
            // Get stock prices (placeholder - integrate with real stock API)
            $stockRates = [
                'success' => true,
                'data' => [
                    'AAPL' => ['price' => 195.10, 'change' => 1.2],
                    'TSLA' => ['price' => 850.20, 'change' => -0.8]
                ]
            ];
            
            return [
                'success' => true,
                'data' => [
                    'crypto' => $cryptoRates,
                    'forex' => $forexRates,
                    'stocks' => $stockRates,
                    'timestamp' => now()->toISOString()
                ],
                'timestamp' => now()->toISOString()
            ];
            
        } catch (\Exception $e) {
            Log::error('Failed to fetch dashboard exchange rates', [
                'error' => $e->getMessage()
            ]);
            
            return $this->errorResponse('Failed to fetch exchange rates', 500, $e->getMessage());
        }
    }
}