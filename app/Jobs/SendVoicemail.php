<?php

namespace App\Jobs;

use App\Mail\SendVoicemail as MailVoicemail;
use App\Models\VoicemailUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVoicemail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $voicemail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $voicemail)
    {
        $this->voicemail = $voicemail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = VoicemailUsers::where('mailbox', $this->voicemail['VM_MAILBOX'])->first()->email;

        Mail::to($email)->send(new MailVoicemail($this->voicemail));
    }
}
