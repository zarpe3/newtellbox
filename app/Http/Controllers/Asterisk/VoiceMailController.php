<?php

namespace App\Http\Controllers\Asterisk;

use App\Actions\Customer\Voicemail\CreateVoicemail;
use App\Actions\Customer\Voicemail\GetEmail;
use App\Actions\Customer\Voicemail\GetVoicemails;
use App\Actions\Customer\Voicemail\UpdateVoicemail;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class VoiceMailController extends Controller
{
    public function show(Customer $customer)
    {
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

    public function update(Customer $customer, Request $request)
    {
        (new UpdateVoicemail())->execute($customer, [
            'email' => $request->email,
            'notify_voicemail' => $request->notify_voicemail,
        ]);

        return redirect()->route('voicemail.index', [$customer->accountcode]);
    }
}
