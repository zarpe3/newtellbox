<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ModelActionBase;
use App\Models\Mailing;

class Import
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        $this->import();
    }

    protected function import()
    {
        $file = file($this->data['file_path']);
        $followUp = $this->data['followUp'];
        try {
            $file_path_error = '';
            $import = $importError = [];
            $line = $fail = $countError = $countImport = 0;

            $this->updateFollowUp('processando', 0, 0, 0, count($file));

            $header = $file[0];
            $header = explode(',', $header);
            unset($file[0]);

            foreach ($file as $key => $row) {
                $row = explode(',', $row);

                $phoneList = $this->getOrderPhone($followUp->id, $line, $row, $header);
                $phoneError = !is_null($phoneList['phoneError']) ? $phoneList['phoneError'] : null;

                $cpf = (new Validate())->execute($this->actionRecord, [
                    'import_id' => $followUp->id,
                    'type' => 'cpf',
                    'data' => ['line' => $line, 'column' => 'cpf'],
                    'value' => $row[6] ?? '',
                    'validate' => $this->data['valid_cpf'],
                ]);

                if (!$cpf['status']) {
                    if (!is_null($phoneError)) {
                        $phoneError['column'] = "{$phoneError['column']}{$cpf['message']['column']}";
                        $phoneError['value'] = "{$phoneError['value']}{$cpf['message']['value']}";
                        $phoneError['message'] = "{$phoneError['message']}{$cpf['message']['message']}";
                    }

                    if (is_null($phoneError)) {
                        $phoneError['import_id'] = $cpf['message']['import_id'];
                        $phoneError['line'] = $cpf['message']['line'];
                        $phoneError['column'] = $cpf['message']['column'];
                        $phoneError['value'] = $cpf['message']['value'];
                        $phoneError['message'] = $cpf['message']['message'];
                    }
                }

                $importError[] = $phoneError;

                if (!empty($phoneList['phoneList'])) {
                    $entry = [
                        'name' => $row[5] ?? '',
                        'cpf' => $cpf['value'] ?? '',
                        'cod_crm' => $row[7] ?? '',
                        'user_id' => $this->data['user_id'],
                        'customer_id' => $this->actionRecord->id,
                        'campaign_id' => $followUp->id,
                        'status' => 0,
                    ];

                    for ($i = 0; $i < 6; ++$i) {
                        if (!empty($phoneList['phoneList'][$i])) {
                            $entry['phones'][] = [
                                'phone' => $phoneList['phoneList'][$i],
                                'schedule' => null,
                                'status' => 0,
                                'attempts' => 0,
                            ];
                        }
                    }

                    $import[] = $entry;
                }

                if (empty($phoneList['phoneList'])) {
                    ++$fail;
                }

                if (count($import) >= 1000) {
                    $countImport = $countImport + 1000;
                    Mailing::insert($import);
                    $import = [];
                }

                $importError = array_values(array_filter($importError));

                if (count($importError) >= 1000) {
                    $countError = $countError + 1000;
                    $file_path_error = $this->mailingError($importError);
                    $importError = [];
                }

                ++$line;
            }

            $importError = array_values(array_filter($importError));

            if (!empty($import)) {
                Mailing::insert($import);
            }

            if (!empty($importErro)) {
                $file_path_error = $this->mailingError($importError);
            }

            $this->updateFollowUp('pausado', count($import) + $countImport, 0, 0, null, $file_path_error);
        } catch (\Exception $exception) {
            $this->cancelFollowUp($followUp, $exception);

            return [
                'status' => false,
                'error' => $exception->getMessage(),
            ];
        }

        return true;
    }

    private function mailingError($importError)
    {
        return (new WriteMailingError())->execute($this->actionRecord, [
            'now' => $this->data['now'],
            'importError' => $importError,
        ]);
    }

    private function getOrderPhone($import_id, $line, $row, $header)
    {
        return (new GetOrderPhone())->execute($this->actionRecord, [
            'import_id' => $import_id,
            'line' => $line,
            'row' => $row,
            'header' => $header,
        ]);
    }

    private function updateFollowUp($status, $success, $fail, $errors, $size = null, $file_path_error = null)
    {
        $this->data['followUp']->status = $status;

        if ($size) {
            $this->data['followUp']->size = $size;
        }

        if ($file_path_error) {
            $this->data['followUp']->file_path_error = $file_path_error;
        }

        $this->data['followUp']->success = $success;
        $this->data['followUp']->fail = $fail;
        $this->data['followUp']->errors = $errors;
        $this->data['followUp']->save();
    }

    private function cancelFollowUp($followUp, $exception)
    {
        $followUp->status = 'cancelado';
        $followUp->cancelMessage = json_encode([
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'log' => $exception->getMessage(),
        ]);
        $followUp->save();
    }
}
