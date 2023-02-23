<?php

namespace App\Actions\Customer;

use App\Actions\Customer\Files\StoreTmpFile;
use App\Actions\ModelActionBase;
use App\Models\MailingFollowUp;
use App\Traits\Helper;
use App\Traits\Mailing;

class MailingAction
{
    use ModelActionBase, Mailing, Helper;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        switch ($this->data['action']) {
            case 'GET':
                return MailingFollowUp::where(['customer_id' => $this->actionRecord->id])
                ->latest()
                ->paginate();
                break;
            case 'import':
                $now = time();
                $response = (new StoreTmpFile())->execute($this->actionRecord, [
                    'file' => $this->data['mailing'],
                    'newName' => $now
                ]);
                $args = [
                    'file_path' => storage_path("app/{$response}"),
                    'user_id' => $this->data['user_id'],
                    'customer_id' => $this->actionRecord->id,
                    'accountcode' => $this->actionRecord->accountcode,
                    'valid_cpf' => $this->data['valid_cpf'],
                    'campaign_name' => $this->data['campaign_name'],
                    'now' => $now
                ];
                $args['followUp'] = self::startProcess($args);
                if ($args['followUp'] !== false) {
                    dispatch(function () use ($args) {
                        ini_set('memory_limit', '4095M');
                        set_time_limit(0);
                        \App\Actions\Customer\MailingAction::import($args);
                    })->onQueue('mailing');
                    return [
                        'status' => true,
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'Não foi possível enviar o arquivo no momento, tente mais tarde.'
                    ];
                }
                break;
            default:
                return [
                    'status' => true,
                ];
                break;
        }
    }
}
