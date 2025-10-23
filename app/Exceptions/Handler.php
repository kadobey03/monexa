<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use App\Models\Settings;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        $response = parent::render($request, $exception);
        
        // Add settings to error views to prevent undefined variable errors
        if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 600) {
            try {
                $settings = Settings::where('id', 1)->first();
                if ($settings) {
                    $response->setContent(
                        str_replace(
                            '</body>',
                            '<script>window.settings = ' . json_encode($settings) . ';</script></body>',
                            $response->getContent()
                        )
                    );
                    
                    // For view-based error pages, pass settings
                    if (view()->exists('errors.' . $response->getStatusCode()) ||
                        view()->exists('errors.minimal')) {
                        return response()->view('errors.minimal', [
                            'settings' => $settings
                        ], $response->getStatusCode());
                    }
                }
            } catch (\Exception $e) {
                // Fallback - don't break error handling
            }
        }
        
        return $response;
    }
}
