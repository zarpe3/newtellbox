<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ModelActionBase;
use App\Models\Mailing;
use App\Models\MailingFollowUp;
use App\Models\Queue;

class DeleteMailing
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'] ?? null,
        ];
    }

    protected function main()
    {
        if ($this->data['id']) {
            Queue::where('name', $this->actionRecord->accountcode.'_'.$this->data['id'])->delete();
            MailingFollowUp::where('_id', $this->data['id'])->delete();
            Mailing::where('campaign_id', $this->data['id'])->delete();

            return true;
        }

        return false;
    }
}
