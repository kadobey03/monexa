<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MarketRatesController extends Controller
{
    public function __construct(
        private ApiClientService $apiClient
    ) {}

    /**
     * Get market rates for dashboard
     * GET /api/market-rates
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $type = $request->query('type', 'all');
            
            // Rate limiting per user (simple implementation)
            $userId = Auth::id();
            $cacheKey = "market_rates_{$userId}_{$type}";
            
            // Check cache first (simple file-based caching)
            $cachedData = cache($cacheKey);
            if ($cachedData) {
                return response()->json($cachedData);
            }

            $result = $this->apiClient->getDashboardExchangeRates();
            
            if (!$result['success']) {
                return $this->marketErrorResponse('Failed to fetch market data', 500);
            }

            // Filter results based on requested type
            $filteredData = $this->filterMarketData($result['data'], $type);
            
            $response = [
                'success' => true,
                'data' => $filteredData,
                'timestamp' => now()->toISOString(),
                'type' => $type
            ];

            // Cache for 60 seconds
            cache([$cacheKey => $response], 60);

            return response()->json($response);

        } catch (\Exception $e) {
            \Log::error('Market rates fetch error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse('Internal server error', 500);
        }
    }

    /**
     * Get cryptocurrency prices
     * GET /api/crypto-prices
     */
    public function cryptoPrices(): JsonResponse
    {
        try {
            $result = $this->apiClient->getCryptoPrices(['bitcoin', 'ethereum', 'binancecoin']);
            
            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'data' => $result['data'],
                    'timestamp' => $result['timestamp']
                ]);
            }

            return $this->marketErrorResponse('Failed to fetch crypto prices', 500);

        } catch (\Exception $e) {
            \Log::error('Crypto prices fetch error', [
                'error' => $e->getMessage()
            ]);

            return $this->marketErrorResponse('Internal server error', 500);
        }
    }

    /**
     * Get forex rates
     * GET /api/forex-rates
     */
    public function forexRates(): JsonResponse
    {
        try {
            $result = $this->apiClient->getForexRates('USD', ['EUR', 'GBP', 'JPY', 'CAD', 'AUD']);
            
            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'data' => $result['data']['rates'] ?? $result['data'],
                    'timestamp' => $result['timestamp']
                ]);
            }

            return $this->marketErrorResponse('Failed to fetch forex rates', 500);

        } catch (\Exception $e) {
            \Log::error('Forex rates fetch error', [
                'error' => $e->getMessage()
            ]);

            return $this->marketErrorResponse('Internal server error', 500);
        }
    }

    /**
     * Get stock prices (placeholder implementation)
     * GET /api/stock-prices
     */
    public function stockPrices(): JsonResponse
    {
        try {
            // In a real implementation, this would integrate with a stock API
            // For now, returning demo data with realistic values
            $demoStocks = [
                'AAPL' => ['price' => 195.10, 'change' => 1.2, 'symbol' => 'AAPL'],
                'TSLA' => ['price' => 850.20, 'change' => -0.8, 'symbol' => 'TSLA'],
                'GOOGL' => ['price' => 142.50, 'change' => 2.1, 'symbol' => 'GOOGL'],
                'MSFT' => ['price' => 378.85, 'change' => 0.5, 'symbol' => 'MSFT'],
                'AMZN' => ['price' => 151.90, 'change' => -1.3, 'symbol' => 'AMZN'],
            ];

            return response()->json([
                'success' => true,
                'data' => $demoStocks,
                'timestamp' => now()->toISOString(),
                'note' => 'Demo data - integrate with real stock API for production'
            ]);

        } catch (\Exception $e) {
            \Log::error('Stock prices fetch error', [
                'error' => $e->getMessage()
            ]);

            return $this->marketErrorResponse('Internal server error', 500);
        }
    }

    /**
     * Get all market data consolidated
     * GET /api/market-overview
     */
    public function marketOverview(): JsonResponse
    {
        try {
            $result = $this->apiClient->getDashboardExchangeRates();
            
            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'crypto' => $result['data']['crypto']['data'] ?? [],
                        'forex' => $result['data']['forex']['data']['rates'] ?? [],
                        'stocks' => $result['data']['stocks']['data'] ?? [],
                        'last_updated' => $result['timestamp']
                    ],
                    'timestamp' => now()->toISOString()
                ]);
            }

            return $this->marketErrorResponse('Failed to fetch market overview', 500);

        } catch (\Exception $e) {
            \Log::error('Market overview fetch error', [
                'error' => $e->getMessage()
            ]);

            return $this->marketErrorResponse('Internal server error', 500);
        }
    }

    /**
     * Filter market data based on type
     */
    private function filterMarketData(array $data, string $type): array
    {
        switch ($type) {
            case 'crypto':
                return $data['crypto']['data'] ?? [];
                
            case 'forex':
                return $data['forex']['data']['rates'] ?? [];
                
            case 'stocks':
                return $data['stocks']['data'] ?? [];
                
            case 'all':
            default:
                return [
                    'crypto' => $data['crypto']['data'] ?? [],
                    'forex' => $data['forex']['data']['rates'] ?? [],
                    'stocks' => $data['stocks']['data'] ?? []
                ];
        }
    }

    /**
     * Standard error response
     */
    private function marketErrorResponse(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'timestamp' => now()->toISOString()
        ], $statusCode);
    }
}