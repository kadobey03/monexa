<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawalRequest;
use App\Services\FinancialService;
use App\Services\UserService;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewNotification;

class WithdrawalController extends Controller
{
    public function __construct(
        private FinancialService $financialService,
        private UserService $userService
    ) {}

    /**
     * Set withdrawal payment method in session
     */
    public function withdrawamount(Request $request): RedirectResponse
    {
        session(['paymentmethod' => $request->method]);
        return redirect()->route('withdrawfunds');
    }

    /**
     * Show withdrawal form
     */
    public function withdrawfunds(): View
    {
        $paymethod = session('paymentmethod');
        $method = \App\Models\Wdmethod::where('name', $paymethod)->first();

        if (!$method) {
            abort(404, 'Payment method not found');
        }

        return view('user.withdraw', [
            'title' => 'Para Çekme Talebini Tamamla',
            'payment_mode' => $paymethod,
            'default' => $method->defaultpay === 'yes',
            'methodtype' => $method->methodtype === 'crypto' ? 'crypto' : 'currency',
        ]);
    }

    /**
     * Generate and send OTP for withdrawal
     */
    public function getotp(): RedirectResponse
    {
        try {
            $code = $this->generateOTP(5);
            $user = auth()->user();

            \App\Models\User::where('id', $user->id)->update(['withdrawotp' => $code]);

            $message = "Para çekme talebi başlattınız, talebinizi tamamlamak için OTP'yi kullanın: {$code}";
            $subject = "OTP Talebi";

            Mail::bcc($user->email)->send(new NewNotification($message, $subject, $user->name));

            return redirect()->back()->with('success', 'İşlem Başarılı! OTP e-posta adresinize gönderildi');

        } catch (\Exception $e) {
            Log::error('OTP generation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('message', 'OTP gönderilemedi. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Verify withdrawal code
     */
    public function userwithdrawal(Request $request): RedirectResponse
    {
        $request->validate([
            'withdrawal_code' => 'required|string',
        ]);

        $user = auth()->user();
        $settings = \App\Models\Settings::where('id', '1')->first();

        if ($request->withdrawal_code !== $user->user_withdrawalcode) {
            return redirect()->back()->with('message',
                "Para çekme kodu yanlış!! Bu işlem için doğru para çekme kodu için lütfen {$settings->contact_email} ile iletişime geçin"
            );
        }

        \App\Models\User::where('id', $user->id)->update(['withdrawal_code' => 'off']);

        return redirect()->back()->with('success',
            'Para çekme kodu doğru, şimdi Para Çekme işleminize devam edebilirsiniz'
        );
    }

    /**
     * Process withdrawal request
     */
    public function completewithdrawal(WithdrawalRequest $request): RedirectResponse
    {
        try {
            $user = auth()->user();

            // Validate KYC via service
            $kycResult = $this->userService->validateKyc($user);
            if (!$kycResult->success && $kycResult->message !== 'KYC already verified') {
                return redirect()->back()->with('message', $kycResult->message);
            }

            // Process withdrawal via service
            $withdrawalData = [
                'amount' => $request->amount,
                'payment_mode' => $request->method,
                'paydetails' => $request->details,
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'swift_code' => $request->swift_code,
                'account_number' => $request->account_no,
            ];

            $result = $this->financialService->processWithdrawal($withdrawalData, $user);

            if (!$result->success) {
                return redirect()->back()->with('message', $result->errorMessage);
            }

            // Clear OTP if used
            if ($user->sendotpemail === 'Yes') {
                \App\Models\User::where('id', $user->id)->update(['withdrawotp' => null]);
            }

            return redirect()->route('withdrawalsdeposits')
                ->with('success', 'İşlem Başarılı! Talebinizi işlerken lütfen bekleyin.');

        } catch (\Exception $e) {
            Log::error('Withdrawal processing failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('message', 'Para çekme işlemi başarısız oldu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Show specific withdrawal details
     */
    public function show(Withdrawal $withdrawal): JsonResponse
    {
        // Ensure user can only view their own withdrawals
        if ($withdrawal->user !== auth()->id()) {
            return $this->errorResponse('Unauthorized', 403);
        }

        return $this->successResponse([
            'withdrawal' => [
                'id' => $withdrawal->id,
                'amount' => $withdrawal->amount,
                'payment_mode' => $withdrawal->payment_mode,
                'status' => $withdrawal->status,
                'created_at' => $withdrawal->created_at?->format('Y-m-d H:i:s'),
            ]
        ]);
    }

    /**
     * Generate random OTP string
     */
    private function generateOTP(int $length): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $otp = '';

        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $otp;
    }
}
