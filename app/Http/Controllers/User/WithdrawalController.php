<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\User_plans;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalStatus;
use App\Traits\Coinpayment;
use App\Traits\TemplateTrait;
use App\Traits\NotificationTrait;

class WithdrawalController extends Controller
{
    use Coinpayment, TemplateTrait, NotificationTrait;
    //
    public function withdrawamount(Request $request)
    {
        $request->session()->put('paymentmethod', $request->method);
        return redirect()->route('withdrawfunds');
    }

    //Return withdrawals route
    public function withdrawfunds()
    {

        $paymethod = session('paymentmethod');

        $checkmethod =  Wdmethod::where('name', $paymethod)->first();
        if ($checkmethod->defaultpay == "yes") {
            $default = true;
        } else {
            $default = false;
        }

        if ($checkmethod->methodtype == "crypto") {
            $methodtype = 'crypto';
        } else {
            $methodtype = 'currency';
        }

        return view("user.withdraw", [
            'title' => 'Para Çekme Talebini Tamamla',
            'payment_mode' => $paymethod,
            'default' => $default,
            'methodtype' => $methodtype,
        ]);
    }

    public function getotp()
    {
        $code = $this->RandomStringGenerator(5);

        $user = Auth::user();
        User::where('id', $user->id)->update([
            'withdrawotp' => $code,
        ]);

        $message = "Para çekme talebi başlattınız, talebinizi tamamlamak için OTP'yi kullanın: $code";
        $subject = "OTP Talebi";

        try {
            Mail::bcc($user->email)->send(new NewNotification($message, $subject, $user->name));
        } catch (\Exception $e) {
            \Log::error('Para çekme OTP e-postası gönderilemedi. Kullanıcı: ' . $user->name . ' (' . $user->email . '), OTP: ' . $code . '. Hata: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'İşlem Başarılı! OTP e-posta adresinize gönderildi');
    }



    public function userwithdrawal(Request $request){
        $settings = Settings::where('id', '1')->first();
         if($request->withdrawal_code != Auth::user()->	user_withdrawalcode){
                 return redirect()->back()->with('message', "Para çekme kodu yanlış!! Bu işlem için doğru para çekme kodu için lütfen $settings->conctact_email ile iletişime geçin");

            }else{

                 $user = Auth::user();
                 User::where('id', $user->id)->update([
                'withdrawal_code' => 'off'

            ]);
                 return redirect()->back()->with('success', "Para çekme kodu doğru, şimdi Para Çekme işleminize devam edebilirsiniz");

            }



    }

    public function completewithdrawal(Request $request)
    {

        if (Auth::user()->sendotpemail == "Yes") {
            if ($request->otpcode != Auth::user()->withdrawotp) {
                return redirect()->back()->with('message', 'OTP yanlış, lütfen kodu tekrar kontrol edin');
            }
        }

        $settings = Settings::where('id', '1')->first();
        if ($settings->enable_kyc == "yes") {
            if (Auth::user()->account_verify != "Verified") {
                return redirect()->back()->with('message', 'Para çekme yapabilmek için hesabınızın doğrulanması gerekir.');
            }
        }

        $method = Wdmethod::where('name', $request->method)->first();

        if ($method->charges_type == 'percentage') {
            $charges = $request['amount'] * $method->charges_amount / 100;
        } else {
            $charges = $method->charges_amount;
        }

        $to_withdraw = $request['amount'] + $charges;
        //return if amount is lesser than method minimum withdrawal amount

        if (Auth::user()->account_bal < $to_withdraw) {
            return redirect()->back()
                ->with('message', 'Üzgünüz, hesap bakiyeniz bu istek için yetersiz.');
        }

        if ($request['amount'] < $method->minimum) {
            return redirect()->back()
                ->with("message", "Üzgünüz, çekebileceğiniz minimum miktar $settings->currency$method->minimum, lütfen başka bir ödeme yöntemi deneyin.");
        }

        //get user last investment package
        User_plans::where('user', Auth::user()->id)
            ->where('active', 'yes')
            ->orderBy('activated_at', 'asc')->first();

        //get user
        $user = User::where('id', Auth::user()->id)->first();

        if ($request->method == 'Bitcoin') {
             User::where('id', $user->id)->update([
                'btc_address' =>$request->details,

            ]);

            $coin = "BTC";
            $wallet = $user->btc_address;
        } elseif ($request->method  == 'Ethereum') {
             User::where('id', $user->id)->update([
                'eth_address' =>$request->details,

            ]);

            $coin = "ETH";
            $wallet = $user->eth_address;
        } elseif ($request->method  == 'Litecoin') {
             User::where('id', $user->id)->update([
                'ltc_address' =>$request->details,

            ]);

            $coin = "LTC";
            $wallet = $user->ltc_address;
        } elseif ($request->method  == 'USDT') {
             User::where('id', $user->id)->update([
                'usdt_address' =>$request->details,

            ]);

            $coin = "USDT.TRC20";
            $wallet = $user->usdt_address;
        } elseif ($request->method  == 'Bank Transfer') {

             User::where('id', $user->id)->update([
                'bank_name' =>$request->bank_name,
                'account_name' =>$request->account_name,
                'swift_code' =>$request->swift_code,
                 'account_number' =>$request->account_no,

            ]);

        }

        $amount = $request['amount'];
        $ui = $user->id;

        if ($settings->deduction_option == "userRequest") {
            //debit user
            User::where('id', $user->id)->update([
                'account_bal' => $user->account_bal - $to_withdraw,
                'withdrawotp' => NULL,
            ]);
        }

        if ($settings->withdrawal_option == "auto" and ($request->method == 'Bitcoin' or $request->method  == 'Litecoin' or $request->method  == 'Ethereum' or $request->method == 'USDT')) {
            return $this->cpwithdraw($amount, $coin, $wallet, $ui, $to_withdraw);
        }

        //save withdrawal info
        $dp = new Withdrawal();
        $dp->amount = $amount;
        $dp->to_deduct = $to_withdraw;
        $dp->payment_mode = $request->method;
        $dp->status = 'Pending';
        $dp->paydetails = $request->details;
        $dp->user = $user->id;
        $dp->save();

        // send mail to admin
        try {
            Mail::to($settings->contact_email)->send(new WithdrawalStatus($dp, $user, 'Withdrawal Request', true));
        } catch (\Exception $e) {
            \Log::error('Para çekme bildirim e-postası yöneticiye gönderilemedi. Kullanıcı: ' . $user->name . ' (' . $user->email . '), Para Çekme ID: ' . $dp->id . ', Miktar: ' . $amount . '. Hata: ' . $e->getMessage());
        }

        //send notification to user
        try {
            Mail::to($user->email)->send(new WithdrawalStatus($dp, $user, 'Successful Withdrawal Request'));
        } catch (\Exception $e) {
            \Log::error('Para çekme onay e-postası kullanıcıya gönderilemedi. Kullanıcı: ' . $user->name . ' (' . $user->email . '), Para Çekme ID: ' . $dp->id . ', Miktar: ' . $amount . '. Hata: ' . $e->getMessage());
        }

        // Send notification to user and admin about the withdrawal
        $this->sendWithdrawalNotification($amount, $settings->currency, $dp->id);

        return redirect()->route('withdrawalsdeposits')
            ->with('success', 'İşlem Başarılı! Talebinizi işlerken lütfen bekleyin.');
    }


    // for front end content management
    function RandomStringGenerator($n)
    {
        $generated_string = "";
        $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }
        // Return the random generated string
        return $generated_string;
    }
}
