<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ModelActionBase;
use App\Models\MailingFollowUp;

class GetMailing
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
            return MailingFollowUp::where(['customer_id' => $this->actionRecord->id])
                ->where('_id', $this->data['id'])
                ->first();
        }

        return MailingFollowUp::where(['customer_id' => $this->actionRecord->id])
            ->latest()
            ->paginate();
    }
}
