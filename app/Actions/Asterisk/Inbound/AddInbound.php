<?php

namespace App\Actions\Asterisk\Inbound;

use App\Actions\ModelActionBase;
use App\Models\Inbound;
use App\Models\VoicemailUsers;

class AddInbound
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'name' => $data['name'] ?? 'No Name',
            'did' => $data['did'] ?? 'No DID',
            'destiny_type' => $data['destiny_type'] ?? '',
            'destiny_value' => $data['destiny_value'] ?? '',
            'customer_id' => $this->actionRecord->id,
        ];
    }

    protected function main()
    {
        $voicemail = VoicemailUsers::where('mailbox', $this->data['did']);

        if ($voicemail->exists()) {
            throw new Exception('Error DID ja existente', 1);
        }

        VoicemailUsers::create([
            'mailbox' => $this->data['did'],
            'context' => 'default',
            'customer_id' => $this->actionRecord->id,
            'fullname' => $this->actionRecord->name,
            'password' => $this->actionRecord->accountcode,
        ]);

        return Inbound::create($this->data);
    }
}
