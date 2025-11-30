<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NewNotification;
use App\Models\Settings;
use App\Models\SettingsCont;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tp_Transaction;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TransferController extends Controller
{
    use PingServer;

    public function transfertouser(Request $request)
    {

        $receiver = User::where('email', $request->email)->first();
        $sender = Auth::user();
        $settings = Settings::find(1);
        $settingss = SettingsCont::find(1);
        $charges = $request->amount * $settingss->transfer_charges / 100;
        $todeduct = $request->amount + $charges;

        if (!Hash::check($request->password, $sender->password)) {
            return response()->json([
                'status' => 419,
                'message' => __('api.security.current_password_incorrect'),
            ]);
        }

        if ($sender->email == $receiver->email) {
            return response()->json([
                'status' => 419,
                'message' => __('api.financial.transfer_self_error'),
            ]);
        }
        if (!$receiver) {
            return response()->json([
                'status' => 419,
                'message' => __('api.validation.user_not_found'),
            ]);
        }

        if ($sender->account_bal < $todeduct) {
            return response()->json([
                'status' => 419,
                'message' => __('api.financial.insufficient_balance'),
            ]);
        }

        $user = User::find(Auth::user()->id);
        $user->account_bal = $sender->account_bal - $todeduct;
        $user->save();

        User::where('email', $request->email)->update([
            'account_bal' => $receiver->account_bal + $request->amount,
        ]);

        //create history
        Tp_Transaction::create([
            'user' => $sender->id,
            'plan' => "Transfered to $receiver->name",
            'amount' => $request->amount,
            'type' => "Fund Transfer",
        ]);

        //create history for receiver
        Tp_Transaction::create([
            'user' => $receiver->id,
            'plan' => "Received from $sender->name",
            'amount' => $request->amount,
            'type' => "Fund Transfer",
        ]);


        $message = "You just received $settings->currency$request->amount from $sender->name and your account balance is now $settings->currency$receiver->account_bal";

        try {
            Mail::to($receiver->email)->send(new NewNotification($message, 'Credit Alert', $receiver->name));
        } catch (\Exception $e) {
            \Log::error('Failed to send transfer notification email. Sender: ' . $sender->name . ' (' . $sender->email . '), Receiver: ' . $receiver->name . ' (' . $receiver->email . '), Amount: ' . $request->amount . '. Error: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 200,
            'message' => __('api.financial.transfer_successful'),
        ]);
    }


    public function renewSignalSub()
    {
        $user = User::find(Auth::user()->id);
        $response = $this->fetctApi('/subscription', [
            'id' => auth()->user()->id
        ]);
        $res = json_decode($response);
        $sub = $res->data;

        $responseSt = $this->fetctApi('/signal-settings');
        $info = json_decode($responseSt);
        $settings = $info->data->settings;

        if ($sub->subscription == 'Monthly') {
            $amount = $settings->signal_monthly_fee;
        } elseif ($sub->subscription == 'Quarterly') {
            $amount = $settings->signal_quartly_fee;
        } else {
            $amount = $settings->signal_yearly_fee;
        }

        if ($user->account_bal <  floatval($amount)) {
            return redirect()->back()->with('message', 'Your have insufficient funds in your account balance to perform this operation');
        }

        $renew =  $this->fetctApi('/renew-subscription', [
            'id' => $user->id,
        ], 'POST');

        if ($renew->successful()) {
            $user->account_bal = $user->account_bal - floatval($amount);
            $user->save();
            return redirect()->back()->with('success', 'Your subscription have been renewed successfully.');
        }
        return redirect()->back()->with('Something went wrong');
    }
}
