<?php

namespace App\Actions\Customer;

use App\Actions\Asterisk\GetTrunks;
use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\Asterisk\SIP;
use App\Actions\ModelActionBase;

class ShowDashboard
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
        ];
    }

    protected function main()
    {
        $extens = (new SIP())->execute($this->actionRecord, ['request' => 'GET']);
        $trunks = (new GetTrunks())->execute($this->actionRecord, []);
        $queues = (new GetQueue())->execute($this->actionRecord, ['toArray' => true]);

        return $this->validateResponse($extens, $trunks, $queues);
    }

    private function validateResponse($extens, $trunks, $queues)
    {
        if (!$extens['success']) {
            $extens['extens'] = [];
        }

        return [
            'extens' => $extens['extens'],
            'trunks' => $trunks['response'],
            'queues' => $queues,
        ];
    }
}
