<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Services\FinancialService;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    public function __construct(
        private FinancialService $financialService
    ) {}

    /**
     * Get payment method name by ID
     */
    public function getmethod(int $id): JsonResponse
    {
        // This method can be moved to a dedicated PaymentMethodController if needed
        // For now, keeping it here as it's a simple lookup
        $method = \App\Models\Wdmethod::find($id);

        if (!$method) {
            return $this->errorResponse('Payment method not found', 404);
        }

        return $this->successResponse(['name' => $method->name]);
    }

    /**
     * Show new deposit form with payment method
     */
    public function newdeposit(Request $request): RedirectResponse
    {
        $paymentMethod = $request->payment_method ?: 'Bitcoin';

        // Store payment info in session for backward compatibility
        session([
            'amount' => $request->amount,
            'payment_mode' => $paymentMethod,
            'asset' => $request->asset,
        ]);

        return redirect()->route('payment');
    }

    /**
     * Show payment page
     */
    public function payment(Request $request): View
    {
        $method = \App\Models\Wdmethod::firstWhere('name', session('payment_mode'));

        return view('user.payment', [
            'amount' => session('amount'),
            'payment_mode' => $method,
            'intent' => session('intent'),
            'asset' => session('asset'),
            'title' => 'Make Payment',
        ]);
    }

    /**
     * Process Stripe payment (legacy method - consider deprecation)
     */
    public function savestripepayment(Request $request): JsonResponse
    {
        try {
            // Validate request
            $request->validate([
                'amount' => 'required|numeric|min:10',
            ]);

            // Process deposit via service
            $result = $this->financialService->processDeposit([
                'amount' => $request->amount,
                'payment_mode' => 'Stripe',
                'status' => 'Processed',
                'proof' => 'Credit Card',
            ], auth()->user());

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage);
            }

            // Clear session
            session()->forget(['payment_mode', 'amount', 'intent', 'asset']);

            return $this->successResponse(
                ['deposit_id' => $result->deposit->id],
                'Payment completed successfully'
            );

        } catch (\Exception $e) {
            Log::error('Stripe payment processing failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return $this->errorResponse('Payment processing failed', 500);
        }
    }

    /**
     * Store deposit request with proof upload
     */
    public function savedeposit(DepositRequest $request): RedirectResponse
    {
        try {
            // Handle file upload if present
            $proofPath = null;
            if ($request->hasFile('proof')) {
                $file = $request->file('proof');
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['pdf', 'doc', 'jpeg', 'jpg', 'png'];

                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    return redirect()->back()->with('message', 'Unaccepted file type uploaded');
                }

                $proofPath = $file->store('uploads', 'public');
            }

            // Process deposit via service
            $result = $this->financialService->processDeposit([
                'amount' => $request->amount,
                'payment_mode' => $request->payment_method,
                'status' => 'Pending',
                'proof' => $proofPath,
                'signals' => $request->asset,
            ], auth()->user());

            if (!$result->success) {
                return redirect()->back()->with('message', $result->errorMessage);
            }

            // Clear session
            session()->forget(['payment_mode', 'amount', 'asset']);

            return redirect()->route('deposits')
                ->with('success', 'Deposit request submitted successfully! Please wait for system validation.');

        } catch (\Exception $e) {
            Log::error('Deposit saving failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('message', 'Deposit processing failed. Please try again.');
        }
    }

    /**
     * Show specific deposit details
     */
    public function show(Deposit $deposit): JsonResponse
    {
        // Ensure user can only view their own deposits
        if ($deposit->user !== auth()->id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        return $this->successResponse([
            'deposit' => [
                'id' => $deposit->id,
                'amount' => $deposit->amount,
                'payment_mode' => $deposit->payment_mode,
                'status' => $deposit->status,
                'proof' => $deposit->proof,
                'created_at' => $deposit->created_at?->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
