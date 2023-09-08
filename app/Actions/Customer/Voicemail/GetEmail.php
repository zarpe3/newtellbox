<?php

namespace App\Actions\Customer\Voicemail;

use App\Actions\ModelActionBase;
use App\Models\VoicemailUsers;

class GetEmail
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
    }

    protected function main()
    {
        $voicemail = VoicemailUsers::where('customer_id', $this->actionRecord->id);

        if (!$voicemail->exists()) {
            return '';
        }

        return $voicemail->get()[0]->email;
    }
}
