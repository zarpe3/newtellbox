<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\Asterisk\Queue\EditQueue;
use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\ModelActionBase;
use App\Models\MailingFollowUp;

class UpdateMailing extends MailingBase
{
    use ModelActionBase;

    /**
     * setParameters.
     *
     * @param array data
     */
    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'] ?? null,
            'campaign_name' => $data['campaign_name'],
            'amd' => $data['amd'],
            'agents' => $data['agents'],
            'bina' => $data['bina'],
            'wrapuptime' => $data['wrapuptime'],
            'timeout' => $data['timeout'],
            'max_attempts' => $data['max_attempts'],
            'strength' => $data['strength'],
            'valid_cpf' => $data['valid_cpf'] ?? '0',
            'route' => $data['route'],
            'calendar' => $data['calendar'] ?? [
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
                ['00:00', '00:00'],
            ],
        ];
    }

    /**
     * main.
     *
     * @return void
     */
    protected function main()
    {
        MailingFollowUp::where(['customer_id' => $this->actionRecord->id])
            ->where('_id', $this->data['id'])
            ->update([
                'campaign_name' => $this->data['campaign_name'],
                'amd' => $this->data['amd'],
                'bina' => $this->data['bina'],
                'wrapuptime' => $this->data['wrapuptime'],
                'timeout' => $this->data['timeout'],
                'strength' => $this->data['strength'],
                'max_attempts' => $this->data['max_attempts'],
                'valid_cpf' => $this->data['valid_cpf'],
                'route' => $this->data['route'],
                'agents' => $this->data['agents'],
                'calendar' => $this->data['calendar'],
            ]);

        $this->addAccToAgents();
        (new EditQueue())->execute($this->actionRecord, [
            'id' => $this->getQueueId(),
            'name' => $this->data['id'],
            'agents' => $this->data['agents'],
            'wrapuptime' => $this->data['wrapuptime'],
            'timeout' => $this->data['timeout'],
        ]);

        response()->json(['success' => true]);
    }

    protected function getQueueId()
    {
        $queue = (new GetQueue())->execute($this->actionRecord, ['name' => $this->data['id']]);

        return $queue->id;
    }
}
