<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\Asterisk\Queue\AddQueue;
use App\Actions\Customer\Files\StoreTmpFile;
use App\Actions\ModelActionBase;
use App\Jobs\MailingImport;
use App\Models\MailingFollowUp;
use App\Traits\Helper;

class AddMailing extends MailingBase
{
    use ModelActionBase;
    use Helper;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        $now = time();
        $response = (new StoreTmpFile())->execute($this->actionRecord, [
            'file' => $this->data['mailing'],
            'newName' => $now,
        ]);
        unset($this->data['mailing']); //// remove to be able to send to job;
        $this->data['file_path'] = storage_path("app/{$response}");
        $this->data['customer_id'] = $this->actionRecord->id;
        $this->data['accountcode'] = $this->actionRecord->accountcode;
        $this->data['now'] = $now;
        $this->data['followUp'] = $this->startProcess($this->data);
        $this->createQueue();

        if ($this->data['followUp'] !== false) {
            MailingImport::dispatch($this->data);

            return [
                'status' => true,
            ];
        }

        return [
            'status' => false,
            'message' => 'Não foi possível enviar o arquivo no momento, tente mais tarde.',
        ];
    }

    private function startProcess($data)
    {
        try {
            $followUp = new MailingFollowUp();
            $followUp->user_id = $data['user_id'] ?? null;
            $followUp->customer_id = $data['customer_id'] ?? null;
            $followUp->accountCode = $this->actionRecord->accountcode;
            $followUp->campaign_name = $data['campaign_name'] ?? 'padrão';
            $followUp->valid_cpf = $data['valid_cpf'] ?? '1';
            $followUp->status = 'aguardando';
            $followUp->size = 0;
            $followUp->success = 0;
            $followUp->fail = 0;
            $followUp->errors = 0;
            $followUp->cancelMessage = '';
            $followUp->file_path = $data['file_path'];
            $followUp->file_path_error = '';
            ////campaign details
            $followUp->amd = $data['amd'];
            $followUp->agents = $data['agents'];
            $followUp->route = $data['route'];
            $followUp->bina = $data['bina'];
            $followUp->wrapuptime = $data['wrapuptime'];
            $followUp->timeout = $data['timeout'];
            $followUp->max_attempts = $data['max_attempts'];
            $followUp->strength = $data['strength'];
            $followUp->calendar = $data['calendar'];

            $followUp->save();
        } catch (\Exception $exception) {
            unset($file);
        }

        return $followUp ?? false;
    }

    private function createQueue()
    {
        $this->addAccToAgents();
        (new AddQueue())->execute($this->actionRecord, [
            'name' => $this->data['followUp']->_id,
            'agents' => $this->data['agents'],
            'wrapuptime' => $this->data['wrapuptime'],
            'timeout' => $this->data['timeout'],
        ]);
    }
}
