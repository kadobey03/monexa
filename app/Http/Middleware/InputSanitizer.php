<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class InputSanitizer
{
    /**
     * Gelişmiş input sanitization middleware'i
     * Finansal uygulamalar için özel olarak tasarlanmış
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Tüm input verilerini sanitiz et
        $this->sanitizeInput($request);

        // SQL injection koruması
        if ($this->containsSuspiciousContent($request)) {
            return $this->blockSuspiciousRequest($request);
        }

        $response = $next($request);

        // Yanıt içeriğini de sanitiz et (eğer gerekirse)
        return $this->sanitizeResponse($response);
    }

    /**
     * Input verilerini sanitiz et
     */
    private function sanitizeInput(Request $request): void
    {
        // POST ve GET parametreleri
        $this->sanitizeArray($request->all());

        // JSON payload
        if ($request->isJson()) {
            $jsonData = $request->json()->all();
            $sanitizedJson = $this->sanitizeArray($jsonData);
            $request->json()->replace($sanitizedJson);
        }

        // File uploads güvenlik kontrolü
        if ($request->hasFile('*')) {
            $this->validateFileUploads($request);
        }
    }

    /**
     * Array ve object verilerini sanitiz et
     */
    private function sanitizeArray($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $data[$key] = $this->sanitizeString($value, $key);
                } elseif (is_array($value)) {
                    $data[$key] = $this->sanitizeArray($value);
                }
            }
        } elseif (is_object($data)) {
            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $data->$key = $this->sanitizeString($value, $key);
                } elseif (is_array($value) || is_object($value)) {
                    $data->$key = $this->sanitizeArray($value);
                }
            }
        }

        return $data;
    }

    /**
     * String verilerini sanitiz et
     */
    private function sanitizeString(string $value, string $key): string
    {
        // Temel temizlik
        $value = trim($value);
        $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Finansal veriler için özel kurallar
        if ($this->isFinancialField($key)) {
            return $this->sanitizeFinancialData($value, $key);
        }

        // Email alanları
        if (Str::contains($key, ['email', 'mail'])) {
            return filter_var($value, FILTER_SANITIZE_EMAIL);
        }

        // Telefon numaraları
        if (Str::contains($key, ['phone', 'tel', 'mobile'])) {
            return preg_replace('/[^0-9+\-\(\)\s]/', '', $value);
        }

        // URL'ler
        if (Str::contains($key, ['url', 'link', 'website'])) {
            return filter_var($value, FILTER_SANITIZE_URL);
        }

        // IP adresleri
        if (Str::contains($key, ['ip', 'address'])) {
            return filter_var($value, FILTER_VALIDATE_IP) ? $value : '';
        }

        return $value;
    }

    /**
     * Finansal veriler için özel sanitization
     */
    private function sanitizeFinancialData(string $value, string $key): string
    {
        // Miktar/money alanları
        if (Str::contains($key, ['amount', 'price', 'cost', 'fee', 'balance', 'total'])) {
            // Sadece rakam, nokta ve virgül izin ver
            $value = preg_replace('/[^0-9.,]/', '', $value);
            
            // Binlik ayırıcıları temizle
            $value = str_replace(',', '', $value);
            
            // Pozitif değer kontrolü
            if (is_numeric($value) && $value >= 0) {
                return $value;
            }
            return '0';
        }

        // Kredi kartı numaraları
        if (Str::contains($key, ['card', 'credit', 'cc'])) {
            // Sadece rakamları al
            $value = preg_replace('/[^0-9]/', '', $value);
            
            // Uzunluk kontrolü
            if (strlen($value) >= 13 && strlen($value) <= 19) {
                return $value;
            }
            return '';
        }

        // CVV
        if (Str::contains($key, ['cvv', 'cvc'])) {
            $value = preg_replace('/[^0-9]/', '', $value);
            if (strlen($value) >= 3 && strlen($value) <= 4) {
                return $value;
            }
            return '';
        }

        // IBAN
        if (Str::contains($key, ['iban', 'account'])) {
            $value = strtoupper(preg_replace('/[^A-Z0-9]/', '', $value));
            if (strlen($value) >= 15 && strlen($value) <= 34) {
                return $value;
            }
            return '';
        }

        return $value;
    }

    /**
     * Finansal alan kontrolü
     */
    private function isFinancialField(string $key): bool
    {
        $financialFields = [
            'amount', 'price', 'cost', 'fee', 'balance', 'total', 'payment',
            'deposit', 'withdrawal', 'investment', 'profit', 'loss', 'commission',
            'currency', 'card', 'credit', 'cc', 'cvv', 'cvc', 'iban', 'account',
            'bank', 'swift', 'bic', 'routing', 'sort', 'sort_code'
        ];

        foreach ($financialFields as $field) {
            if (Str::contains($key, $field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Şüpheli içerik kontrolü
     */
    private function containsSuspiciousContent(Request $request): bool
    {
        $allInput = array_merge_recursive(
            $request->all(),
            $request->query(),
            $request->json() ? $request->json()->all() : []
        );

        $suspiciousPatterns = [
            // SQL Injection
            '/(\b(union|select|insert|update|delete|drop|create|alter|exec|execute)\b)/i',
            '/(\bor\b\s*\d+\s*=\s*\d+)/i',
            '/(\'\s*or\s*\d+\s*=\s*\d+\s*--)/i',
            
            // XSS
            '/<script[^>]*>.*?<\/script>/is',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload\s*=/i',
            '/onerror\s*=/i',
            '/onclick\s*=/i',
            
            // Path traversal
            '/\.\.\//',
            '/\.\.\\//',
            '/etc\/passwd/i',
            '/win\.ini/i',
            
            // Command injection
            '/\|\s*cat\b/i',
            '/\|\s*ls\b/i',
            '/\|\s*rm\b/i',
            '/\|\s*cp\b/i',
            
            // NoSQL injection
            '/(\$\w+)/',
            '/(\{.*\})/',
            
            // LDAP injection
            '/\*\)/',
            '/\(\|/',
        ];

        foreach ($this->flattenArray($allInput) as $input) {
            if (is_string($input)) {
                foreach ($suspiciousPatterns as $pattern) {
                    if (preg_match($pattern, $input)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Şüpheli isteği engelle
     */
    private function blockSuspiciousRequest(Request $request): Response
    {
        $this->logSecurityIncident($request, 'suspicious_input_detected');

        return response()->json([
            'error' => [
                'code' => 'SECURITY_VIOLATION',
                'message' => 'Güvenlik ihlali tespit edildi.'
            ]
        ], 403);
    }

    /**
     * Dosya yükleme güvenlik kontrolü
     */
    private function validateFileUploads(Request $request): void
    {
        foreach ($request->allFiles() as $file) {
            if ($file->isValid()) {
                // Dosya boyutu kontrolü (10MB max)
                if ($file->getSize() > 10 * 1024 * 1024) {
                    throw new \InvalidArgumentException('Dosya boyutu çok büyük.');
                }

                // MIME type kontrolü
                $allowedTypes = [
                    'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                    'application/pdf', 'text/plain',
                    'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ];

                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    throw new \InvalidArgumentException('Dosya türü desteklenmiyor.');
                }

                // Dosya uzantısı kontrolü
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'txt', 'doc', 'docx'];
                
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \InvalidArgumentException('Dosya uzantısı desteklenmiyor.');
                }
            }
        }
    }

    /**
     * Yanıt içeriğini sanitiz et
     */
    private function sanitizeResponse($response)
    {
        // JSON yanıtlar için içerik kontrolü
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $data = $response->getData();
            if (is_array($data) || is_object($data)) {
                $sanitizedData = $this->sanitizeArray($data);
                $response->setData($sanitizedData);
            }
        }

        return $response;
    }

    /**
     * Nested array'leri düzleştir
     */
    private function flattenArray($array, $prefix = '')
    {
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = $prefix ? "{$prefix}.{$key}" : $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Güvenlik olayını logla
     */
    private function logSecurityIncident(Request $request, string $type): void
    {
        $logData = [
            'type' => $type,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => auth()->id(),
            'timestamp' => now(),
            'input' => $this->sanitizeArray($request->all())
        ];

        \Log::channel('security')->warning('Security Incident', $logData);

        // Kritik olaylar için özel log
        if (in_array($type, ['suspicious_input_detected'])) {
            \Log::channel('security_critical')->alert('Critical Security Incident', $logData);
        }
    }
}