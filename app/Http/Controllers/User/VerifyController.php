<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\KycApplicationRequest;
use App\Mail\NewNotification;
use App\Models\Kyc;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class VerifyController extends Controller
{
    //
    public function verifyaccount(KycApplicationRequest $request)
    {
        $user = Auth::user();
        $whitelist = array('jpeg', 'jpg', 'png');

        // filter front of document upload
        $frontimg = $request->file('frontimg');
        $backimg = $request->file('backimg');
        $backimgExtention = $backimg->extension();
        $extension = $frontimg->extension();

        if (!in_array($extension, $whitelist) or !in_array($backimgExtention, $whitelist)) {
            return redirect()->back()
                ->with('message', 'Kabul edilmeyen resim yüklendi, lütfen doğru belgeyi yüklediğinizden emin olun.');
        }

        // upload documents to storage
        $frontimgPath = $frontimg->store('uploads', 'public');
        $backimgPath = $backimg->store('uploads', 'public');

        $kyc = new Kyc();
        $kyc->first_name = $request->first_name;
        $kyc->last_name = $request->last_name;
        $kyc->email = $request->email;
        $kyc->phone_number = $request->phone_number;
        $kyc->dob = $request->dob;
        $kyc->social_media = $request->social_media ? $request->social_media : 'Not provided';
        $kyc->address = $request->address;
        $kyc->city = $request->city;
        $kyc->state = $request->state;
        $kyc->country = $request->country;
        $kyc->document_type = $request->document_type;
        $kyc->frontimg = $frontimgPath;
        $kyc->backimg = $backimgPath;
        $kyc->status = 'Under review';
        $kyc->user_id = $user->id;
        $kyc->save();


        //update user
        User::where('id', $user->id)
            ->update([
                'kyc_id' => $kyc->id,
                'account_verify' => 'Under review',
            ]);

        $settings = Settings::find(1);
        $message = "Bu, $user->name'in KYC(kimlik doğrulaması) için bir istek gönderdiğini bildirmek içindir, lütfen incelemek ve gerekli eylemi almak için yönetici hesabınıza giriş yapın.";
        $subject = "$user->name'den Kimlik Doğrulama İsteği";
        $url = config('app.url') . '/admin/dashboard/kyc';

        try {
            Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin', $url));
        } catch (\Exception $e) {
            \Log::error('KYC doğrulama bildirim e-postası gönderilemedi. Kullanıcı: ' . $user->name . ' (' . $user->email . '), KYC ID: ' . $kyc->id . '. Hata: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'İşlem Başarılı! Başvurunuzu doğrularız, lütfen bekleyin. Başvurunuzun durumu hakkında bir e-posta alacaksınız.');
    }
}
