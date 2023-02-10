<?php

namespace App\Actions\Customer\Voicemail;

use App\Actions\Customer\CustomerAction;
use App\Actions\ModelActionBase;
use App\Models\VoicemailUsers;

class UpdateVoicemail
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'email' => $data['email'] ?? 'system@email',
            'notify_voicemail' => $data['notify_voicemail'],
        ];
    }

    protected function main()
    {
        VoicemailUsers::where('customer_id', $this->actionRecord->id)
            ->update(['email' => $this->data['email']]);

        (new CustomerAction())->execute($this->actionRecord, [
            'action' => 'updateVoicemailNotify',
            'notify_voicemail' => $this->data['notify_voicemail'],
        ]);
    }
}
