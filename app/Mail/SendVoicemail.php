<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVoicemail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('WebDec Voicemail')
            ->view('emails.voicemail', ['details' => $this->details])
            ->attachData(
                base64_decode($this->details['VM_MESSAGEFILE_CONTENT']),
                $this->details['VM_MESSAGEFILE_NAME']
            );;
    }
}
