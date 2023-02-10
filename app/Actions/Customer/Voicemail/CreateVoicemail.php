<?php

namespace App\Actions\Customer\Voicemail;

use App\Actions\ActionBase;
use App\Jobs\SendVoicemail;
use App\Models\Customer;
use App\Models\Voicemail;
use App\Models\VoicemailUsers;
use Carbon\Carbon;
use Exception;

class CreateVoicemail
{
    use ActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'plaintext' => $data['plaintext'] ?? '',
        ];
    }

    protected function main()
    {
        if ($this->data['plaintext'] == '') {
            throw new Exception('Error plaintext not valid', 1);
        }

        $fields = $this->parse($this->data['plaintext']);
        $customer = $this->getCustomer($fields['VM_MAILBOX']);

        $filename = uniqid().'_'.$fields['VM_MAILBOX'].'.mp3';

        (new ConvertVoicemailToMp3())->execute($customer, [
            'filename' => $filename,
            'base64' => $fields['VM_MESSAGEFILE_CONTENT'],
        ]);

        Voicemail::create([
            'customer_id' => $customer->id,
            'name' => $fields['VM_NAME'],
            'duration' => $fields['VM_DUR'],
            'msg_num' => $fields['VM_MSGNUM'],
            'dst' => $fields['VM_MAILBOX'],
            'src' => $fields['VM_CIDNAME'],
            'audio' => $customer->accountcode.'/voicemails/'.$filename,
        ]);

        if ($customer->notify_voicemail) {
            $parameters = ['customer' => $customer];
            SendVoicemail::dispatch(array_merge($fields, $parameters));
        }
    }

    /**
     * parse.
     *
     * @param mixed text
     */
    protected function parse($text): array
    {
        $fields = [
            'VM_NAME' => '',
            'VM_DUR' => '',
            'VM_MSGNUM' => '',
            'VM_MAILBOX' => '',
            'VM_CALLERID' => '',
            'VM_CIDNUM' => '',
            'VM_CIDNAME' => '',
            'VM_DATE' => '',
        ];
        $lines = explode(PHP_EOL, $text);
        $expr = implode('|', array_keys($fields));
        $attachment = '';
        $attachmentContent = '';
        foreach ($lines as $line) {
            $matches = null;
            if (preg_match("/($expr):(.+)/", $line, $matches)) {
                $fields[$matches[1]] = trim($matches[2]);
                continue;
            }

            //Content-Disposition: attachment; filename="msg0005.wav"
            if (!$attachment && preg_match('/Content-Disposition: attachment; filename=\"(.+)\"/', $line, $matches)) {
                $attachment = trim($matches[1]);
                continue;
            }

            if ($attachment) {
                if (preg_match('/^------voicemail/', $line)) {
                    break;
                }

                $attachmentContent .= trim($line);
            }
        }

        if ($fields['VM_DATE']) {
            $fields['VM_DATE'] = Carbon::parse($fields['VM_DATE']);
        }

        $fields['VM_MESSAGEFILE_NAME'] = $attachment;
        $fields['VM_MESSAGEFILE_CONTENT'] = $attachmentContent;
        $fields['VM_MAILBOX'] = intval($fields['VM_MAILBOX']);

        return $fields;
    }

    protected function getCustomer($mailbox)
    {
        $voicemail = VoicemailUsers::where('mailbox', $mailbox);

        if (!$voicemail->exists()) {
            throw new Exception('Invalid Mailbox', 1);
        }

        return Customer::find($voicemail->first()->customer_id);
    }
}
