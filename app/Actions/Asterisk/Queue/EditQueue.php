<?php

namespace App\Actions\Asterisk\Queue;

use App\Actions\ModelActionBase;
use App\Models\Queue;
use App\Models\QueueMember;

class EditQueue extends BaseQueue
{
    use ModelActionBase;
    protected $id;

    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'],
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
        try {
            $queue = Queue::find($this->data['id']);
            QueueMember::where('queue_name', $queue->name)->delete();

            $this->updateQueue($queue);

            if (!is_null($this->data['agentsB64']) && count($this->data['agents']) == 0) {
                $this->data['agents'] = json_decode(base64_decode($this->data['agentsB64']), true);
            }

            $this->setAgents($this->data['agents'], $this->data['name']);
        } catch (\Exception $e) {
            dump('some exception '.$e->getMessage());
        }
    }

    protected function updateQueue(Queue $queue)
    {
        $queue->name = $this->data['name'];
        $queue->strategy = $this->data['strategy'];
        $queue->announce = $this->data['announce'];
        $queue->wrapuptime = $this->data['wrapuptime'];
        $queue->timeout = $this->data['timeout'];
        $queue->save();
    }
}
