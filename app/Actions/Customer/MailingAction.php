<?php

namespace App\Actions\Customer;

use App\Actions\ModelActionBase;
use App\Models\Mailing;

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
                try {
                    $args = [
                        'file_path' => self::uploadFile($this->data['mailing']),
                        'valid_cpf' => $this->data['valid_cpf']
                    ];
                    dispatch(function () use ($args) {
                        try {
                            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\MailingImport([
                                'valid_cpf' => $args['valid_cpf']
                            ]), storage_path($args['file_path']));
                            unlink(storage_path($args['file_path']));
                        } catch (\Exception $exception) {
                            \Log::error('MailingController.import', [
                                'file_path' => storage_path($args['file_path']),
                                'message' => $exception->getMessage()
                            ]);
                        }
                    })->onQueue('mailing');
                } catch (\Exception $exception) {
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
}