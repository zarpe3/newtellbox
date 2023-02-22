<?php

namespace App\Actions\Customer;

use App\Actions\ModelActionBase;
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
            case 'GET':
                return MailingFollowUp::where(['customer_id' => $this->actionRecord->id])
                ->latest()
                ->paginate();
                break;
            case 'import':
                $args = [
                    'file_path' => self::uploadFile($this->data['mailing']),
                    'user_id' => $this->data['user_id'],
                    'customer_id' => $this->actionRecord->id,
                    'valid_cpf' => $this->data['valid_cpf'],
                    'campaign_name' => $this->data['campaign_name']
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
    public static function import($args)
    {
        $file_path = storage_path($args['file_path']);
        $file = file($file_path);
        
        unlink($file_path);
        
        $followUp = $args['followUp'];
        $user_id = $args['user_id'];
        try {
            $line = 0;
            $header = $file[0];
            $header = explode(',', $header);
            unset($file[0]);
            
            $followUp->status = 'processando';
            $followUp->size = count($file);
            $followUp->success = 0;
            $followUp->fail = 0;
            $followUp->errors = 0;
            $followUp->save();

            $fail = 0;
            $import = [];
            $importErro = [];
            $countError = 0;
            $countImport = 0;

            foreach ($file as $key => $row) {
                $row = explode(',', $row);
            
                $phoneList = \App\Actions\Customer\MailingAction::getOrderPhone($followUp->id, $line, $row, $header);
                $phoneError = !is_null($phoneList['phoneError']) ? $phoneList['phoneError'] : null;
                
                
                $cpf = \App\Actions\Customer\MailingAction::validate($followUp->id, 'cpf', [
                    'line' => $line,
                    'column' => 'cpf',
                ], $row[6] ?? '', $args['valid_cpf']);
                
                if (!$cpf['status']) {
                    if (!is_null($phoneError)) {
                        $phoneError['column'] = "{$phoneError['column']}{$cpf['message']['column']}";
                        $phoneError['value'] = "{$phoneError['value']}{$cpf['message']['value']}";
                        $phoneError['message'] = "{$phoneError['message']}{$cpf['message']['message']}";
                    } else {
                        $phoneError['import_id'] = $cpf['message']['import_id'];
                        $phoneError['line'] = $cpf['message']['line'];
                        $phoneError['column'] = $cpf['message']['column'];
                        $phoneError['value'] = $cpf['message']['value'];
                        $phoneError['message'] = $cpf['message']['message'];
                    }
                }
            

                $importErro[] = $phoneError;

                if (!empty($phoneList['phoneList'])) {
                    $import[] = [
                        'phone1' => $phoneList['phoneList'][0] ?? '',
                        'phone2' => $phoneList['phoneList'][1] ?? '',
                        'phone3' => $phoneList['phoneList'][2] ?? '',
                        'phone4' => $phoneList['phoneList'][3] ?? '',
                        'phone5' => $phoneList['phoneList'][4] ?? '',
                        'name' => $row[5] ?? '',
                        'cpf' => $cpf['value'] ?? '',
                        'cod_crm' => $row[7] ?? '',
                        'user_id' => $user_id,
                        'import_id' => $followUp->id,
                    ];
                } else {
                    $fail++;
                }
                
                if (count($import) >= 1000) {
                    $countImport = $countImport + 1000;
                    \App\Models\Mailing::insert($import);
                    $import = [];
                }

                $importErro = array_values(array_filter($importErro));
                
                if (count($importErro) >= 1000) {
                    $countError = $countError + 1000;
                    \App\Models\MailingError::insert($importErro);
                    $importErro = [];
                }
            
                $line++;
            }

            $importErro = array_values(array_filter($importErro));
            
            if (!empty($import)) {
                \App\Models\Mailing::insert($import);
            }
            
            if (!empty($importErro)) {
                \App\Models\MailingError::insert($importErro);
            }

            $followUp->status = 'finalizado';
            $followUp->success = count($import) + $countImport;
            $followUp->fail = $fail;
            $followUp->errors = count($importErro) + $countError;
            $followUp->save();
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

        return true;
    }

    private function uploadFile($file)
    {
        $uploaddir = "mailing";
        $uploadfile1 = "{$uploaddir}/".time().".{$file->extension()}";
        if (!file_exists($uploaddir)) {
            \File::makeDirectory(storage_path("app/{$uploaddir}"), 0777, true, true);
        }

        $file->storeAs('./', $uploadfile1, 'local');
        return "app/{$uploadfile1}";
    }
    private function startProcess($data)
    {
        try {
            $followUp = new \App\Models\MailingFollowUp();
            $followUp->user_id = $data['user_id'] ?? null;
            $followUp->customer_id = $data['customer_id'] ?? null;
            $followUp->campaign_name = $data['campaign_name'] ?? 'padrão';
            $followUp->valid_cpf = $data['valid_cpf'] ?? '1';
            $followUp->status = 'aguardando';
            $followUp->size = 0;
            $followUp->success = 0;
            $followUp->fail = 0;
            $followUp->errors = 0;
            $followUp->cancelMessage = '';
            $followUp->save();
        } catch (\Exception $exception) {
            unset($file);
        }
        
        return $followUp ?? false;
    }
    public static function mergeErrors($importErro)
    {
        $data = [];
        
        $column = '';
        $message = '';
        $valueString = '';
        
        foreach (array_filter($importErro) as $key => $value) {
            $column .= "{$value['column']},";
            $message .= "{$value['message']},";
            $valueString .= "{$value['value']},";
            $data[$value['line']]= [
                'import_id' => $value['import_id'],
                'line' => $value['line'],
                'column' => $column,
                'value' => $valueString,
                'message' => $message,
            ];
        }
        
        return $data;
    }
    public static function getOrderPhone($import_id, $line, $row, $header)
    {
        $index = 0;
        $phoneList = [];
        $phoneError = [];
        foreach ($header as $key => $value) {
            if (str_contains($value, 'phone')) {
                $phone = \App\Actions\Customer\MailingAction::validate($import_id, 'phone', ['line' => $line, 'column' => $value], $row[$index]);
                $phoneList[] = $phone['value'] ?? '';
                $phoneError[] = $phone['message'] ?? '';
                $index++;
            }
        }

        $phoneList = array_filter($phoneList);
        $phoneError = array_filter($phoneError);
        
        if (!empty($phoneError)) {
            $phoneError = array_values(self::mergeErrors($phoneError));
        }
        
        return [
            'phoneList' => array_values($phoneList) ?? [],
            'phoneError' => $phoneError[0] ?? null,
        ];
    }
    public static function validate($import_id, $type, $data, $value, $validate = '1')
    {
        $value = \App\Actions\Customer\MailingAction::removeCharacters($value);
        switch ($type) {
            case 'phone':
                if (strlen($value) < 10 || empty(trim($value))) {
                    return [
                        'status' => false,
                        'message' => [
                            'import_id' => $import_id,
                            'line' => $data['line'],
                            'column' => $data['column'],
                            'value' => '',
                            'message' => 'O telefone precisa ter mais de 10 digitos'
                        ]
                    ];
                }
                break;
            case 'cpf':
                if ($validate == '1'){
                    if (!\App\Actions\Customer\MailingAction::cpf($value)) {
                        return [
                            'status' => false,
                            'message' => [
                                'import_id' => $import_id,
                                'line' => $data['line'],
                                'column' => $data['column'],
                                'value' => !empty($value) ? $value : "",
                                'message' => 'cpf inválido'
                            ]
                        ];
                    }
                }
                break;
            default:
                # code...
                break;
        }

        return [
            'status' => true,
            'value' => $value
        ];
    }
    public static function removeCharacters($string = null)
    {
        $list = [',', '.', ';', '<', '>', ':', '/', '|', '?', ']', '[', '}', '{', '(', ')',
            '=', '+', '-', '_', '"', '\'', '\\'];
        
        if (is_null($string)) {
            return null;
        }

        return trim(str_replace($list, '', $string));
    }
    public static function cpf($cpf)
    {

        // Extract only the numbers
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        // Check if all digits were entered correctly
        if (strlen($cpf) != 11) {
            return false;
        }

        // Checks if a sequence of repeated digits was informed. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Do the calculation to validate the CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
