<?php

namespace App\Actions\Asterisk\Inbound;

use App\Actions\ModelActionBase;
use App\Models\Inbound;
use App\Models\VoicemailUsers;

class EditInbound
{
    use ModelActionBase;
    protected $id;

    public function setParameters(array $data): void
    {
        $this->id = $data['id'];
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
        $voicemail = VoicemailUsers::where('mailbox', Inbound::find($this->id)->did);

        if (!$voicemail->exists()) {
            VoicemailUsers::create([
                'mailbox' => $this->data['did'],
                'context' => 'default',
                'customer_id' => $this->actionRecord->id,
                'fullname' => $this->actionRecord->name,
                'password' => $this->actionRecord->accountcode,
            ]);
        }

        if ($voicemail->exists()) {
            $vm = $voicemail->get()[0];
            $vm->mailbox = $this->data['did'];
            $vm->context = 'default';
            $vm->fullname = $this->actionRecord->name;
            $vm->customer_id = $this->actionRecord->id;
            $vm->save();
        }

        return Inbound::updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->data['name'],
                'did' => $this->data['did'],
                'destiny_type' => $this->data['destiny_type'],
                'destiny_value' => $this->data['destiny_value'],
                'customer_id' => $this->actionRecord->id,
            ]
        );
    }
}
