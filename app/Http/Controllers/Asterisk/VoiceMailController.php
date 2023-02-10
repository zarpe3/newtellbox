<?php

namespace App\Http\Controllers\Asterisk;

use App\Actions\Customer\Voicemail\CreateVoicemail;
use App\Actions\Customer\Voicemail\GetEmail;
use App\Actions\Customer\Voicemail\GetVoicemails;
use App\Actions\Customer\Voicemail\UpdateVoicemail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoiceMailController extends Controller
{
    public function show()
    {
        $customer = Auth::user()->customer;
        $email = (new GetEmail())->execute($customer, []);
        $voicemails = (new GetVoicemails())->execute($customer, []);

        return view('voicemail.index', [
            'email' => $email,
            'voicemail_notify' => $customer->notify_voicemail,
            'voicemails' => $voicemails,
        ]);
    }

    public function voicemail(Request $request)
    {
        (new CreateVoicemail())->execute(['plaintext' => $request->getContent()]);
    }

    public function update(Request $request)
    {
        $customer = Auth::user()->customer;
        (new UpdateVoicemail())->execute($customer, [
            'email' => $request->email,
            'notify_voicemail' => $request->notify_voicemail,
        ]);

        return redirect('/voicemail');
    }
}
