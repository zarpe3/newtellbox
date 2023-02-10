<?php

namespace App\Actions\Asterisk\Queue;

use App\Actions\ModelActionBase;
use App\Models\Queue;
use BaseQueue;

class AddQueue extends BaseQueue
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'name' => $this->actionRecord->accountcode.'_'.$data['name']
                ?? $this->actionRecord->accountcode.'_'.'NoName',
            'strategy' => $data['strategy'] ?? 'ringall',
            'announce' => $data['announce'] ?? 0,
            'wrapuptime' => $data['wrapuptime'] ?? 0,
            'timeout' => $data['timeout'] ?? 15,
            'agents' => $data['agents'] ?? [],
            'agentsB64' => $data['agentsB64'] ?? null,
            'setinterfacevar' => 1,
            'ringinuse' => 1,
            'customer_id' => $this->actionRecord->id,
        ];
    }

    protected function main()
    {
        $queue = Queue::create($this->data);

        if (!is_null($this->data['agentsB64']) && count($this->data['agents']) == 0) {
            $this->data['agents'] = json_decode(base64_decode($this->data['agentsB64']), true);
        }

        $this->setAgents($this->data['agents'], $this->data['name']);
    }
}
