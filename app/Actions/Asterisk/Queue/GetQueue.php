<?php

namespace App\Actions\Asterisk\Queue;

use App\Actions\ModelActionBase;
use App\Models\Queue;

class GetQueue
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'] ?? null,
            'name' => $data['name'] ?? null,
        ];
    }

    protected function main()
    {
        if (!isset($this->data['name'])) {
            return $this->getQueueById();
        }

        if (isset($this->data['name'])) {
            \Log::info('estou procurando a fila '.$this->actionRecord->accountcode.'_'.$this->data['name']);

            return Queue::where('name', $this->actionRecord->accountcode.'_'.$this->data['name'])->get()[0];
        }
    }

    protected function getQueueById()
    {
        $customerId = $this->actionRecord->id;

        $queue = Queue::with('agents')->customerId($customerId);

        if (isset($this->data['id'])) {
            $queue->where('id', $this->data['id']);
        }

        return $queue->get()->transform(function ($queue) {
            $response = [
                'id' => $queue->id,
                'name' => str_replace($this->actionRecord->accountcode.'_', '', $queue->name),
                'strategy' => $queue->strategy,
                'wrapuptime' => $queue->wrapuptime,
                'timeout' => $queue->timeout,
                'announce' => $queue->announce,
                'created_at' => $queue->created_at,
            ];

            $agentsResponse = [];
            foreach ($queue->agents as $agent) {
                $agentsResponse[] = str_replace(['Local/', '@queue_out/n'], '', $agent->interface);
            }

            $response['agents'] = $agentsResponse;

            return $response;
        });
    }
}
