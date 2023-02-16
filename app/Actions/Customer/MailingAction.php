<?php

namespace App\Actions\Customer;

use App\Actions\ModelActionBase;
use App\Models\Mailing;
use App\Models\MailingFollowUp;

class MailingAction
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        switch ($this->data['action']) {
            case 'getdata':
                return [
                    'status' => true,
                    'data' => Mailing::where(['user_id' => \Auth::id()])->get()
                ];
                break;
            case 'import':
                $file_path = self::uploadFile($this->data['mailing']);
                $followUp = self::startProcess($this->data['campaign_name']);
                try {
                    $args = [
                        'file_path' => $file_path,
                        'valid_cpf' => $this->data['valid_cpf'],
                        'import_id' => $followUp->id
                    ];
                    dispatch(function () use ($args) {
                        try {
                            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\MailingImport([
                                'valid_cpf' => $args['valid_cpf'],
                                'import_id' => $args['import_id']
                            ]), storage_path($args['file_path']));
                            unlink(storage_path($args['file_path']));
                        } catch (\Exception $exception) {
                            $followUp = \App\Models\MailingFollowUp::find($args['import_id']);
                            $followUp->status = 'cancelado';
                            $followUp->cancelMessage = json_encode([
                                'file' => $exception->getFile(),
                                'line' => $exception->getLine(),
                                'log' => $exception->getMessage()
                            ]);
                            $followUp->save();
                            unlink(storage_path($args['file_path']));
                            \Log::error('MailingController.import', [
                                'file_path' => storage_path($args['file_path']),
                                'message' => $exception->getMessage()
                            ]);
                        }
                    })->onQueue('mailing');
                
                } catch (\Exception $exception) {
                    $followUp->status = 'cancelado';
                    $followUp->cancelMessage = json_encode([
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'log' => $exception->getMessage()
                    ]);
                    $followUp->save();
                    return [
                        'status' => false,
                        'error' => $exception->getMessage()
                    ];
                }
                return [
                    'status' => true,
                ];
                break;
            default:
                return [
                    'status' => true,
                ];
                break;
        }
    }

    private function uploadFile($file)
    {
        $uploaddir = "mailing";
        $uploadfile1 = "{$uploaddir}/".time().".{$file->extension()}";
        if (!file_exists($uploaddir)) {
            \File::makeDirectory($uploaddir, 0777, true, true);
        }

        $file->storeAs('./', $uploadfile1, 'local');
        return "app/{$uploadfile1}";
    }
    private function startProcess($campaign_name)
    {
        $followUp = new MailingFollowUp();
        $followUp->user_id = \Auth::id();
        $followUp->campaign_name = $campaign_name;
        $followUp->status = 'aguardando';
        $followUp->size = 0;
        $followUp->success = 0;
        $followUp->fail = 0;
        $followUp->errors = 0;
        $followUp->cancelMessage = '';
        $followUp->save();
        return $followUp;
    }
}
