<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class CryptoController extends Controller
{
    /**
     * Get cryptocurrency prices via proxy
     */
    public function getPrices(Request $request): JsonResponse
    {
        try {
            // Cache prices for 30 seconds to reduce API calls
            $cacheKey = 'crypto_prices_' . md5($request->getQueryString() ?? '');
            
            $data = Cache::remember($cacheKey, 30, function() use ($request) {
                // Default parameters
                $ids = $request->get('ids', 'bitcoin,ethereum');
                $vs_currencies = $request->get('vs_currencies', 'usd');
                $include_24hr_change = $request->get('include_24hr_change', 'true');
                
                $response = Http::timeout(10)
                    ->retry(2, 1000)
                    ->get('https://api.coingecko.com/api/v3/simple/price', [
                        'ids' => $ids,
                        'vs_currencies' => $vs_currencies,
                        'include_24hr_change' => $include_24hr_change
                    ]);
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                // Fallback data if API fails
                return [
                    'bitcoin' => [
                        'usd' => 45320,
                        'usd_24h_change' => 2.5
                    ],
                    'ethereum' => [
                        'usd' => 2850,
                        'usd_24h_change' => 1.8
                    ]
                ];
            });
            
            return response()->json($data);
            
        } catch (\Exception $e) {
            // Return fallback data on error
            return response()->json([
                'bitcoin' => [
                    'usd' => 45320,
                    'usd_24h_change' => 2.5
                ],
                'ethereum' => [
                    'usd' => 2850,
                    'usd_24h_change' => 1.8
                ]
            ]);
        }
    }
}