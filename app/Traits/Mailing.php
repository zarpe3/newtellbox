<?php

namespace App\Traits;

use App\Models\MailingFollowUp;

trait Mailing
{
    private static function import($args)
    {
        
        $file = file($args['file_path']);
        $followUp = $args['followUp'];
        
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
                        'user_id' => $args['user_id'],
                        'customer_id' => $args['customer_id'],
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
                    $file_path_error = self::mailingError($args, $importErro);
                    $importErro = [];
                }
            
                $line++;
            }
            $importErro = array_values(array_filter($importErro));

            if (!empty($import)) {
                \App\Models\Mailing::insert($import);
            }
            
            if (!empty($importErro)) {
                $file_path_error = \App\Actions\Customer\MailingAction::mailingError($args, $importErro);
            }
            
            $followUp->status = 'finalizado';
            $followUp->success = count($import) + $countImport;
            $followUp->fail = $fail;
            $followUp->errors = count($importErro) + $countError;
            $followUp->file_path_error = $file_path_error;
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
    private function startProcess($data)
    {
        try {
            $followUp = new MailingFollowUp();
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
            $followUp->file_path = $data['file_path'];
            $followUp->file_path_error = '';
            $followUp->save();
        } catch (\Exception $exception) {
            unset($file);
        }
        
        return $followUp ?? false;
    }
    private static function mailingError($args, $importErro)
    {
        $file_path = storage_path("app/{$args['accountcode']}/tmp/");
        if (!file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }

        $file_path = "{$file_path}{$args['now']}-error.csv";
        $file_handle = fopen($file_path, 'w');
        $file_handle = fopen($file_path, 'a+');
        
        foreach ($importErro as $line) {
            $line = "{$line['line']},{$line['column']},{$line['value']},{$line['message']}";
            fwrite($file_handle, $line . "\n");
        }
        
        fclose($file_handle);

        return $file_path;
    }
    
    private static function mergeErrors($importErro)
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
    private static function getOrderPhone($import_id, $line, $row, $header)
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
    private static function validate($import_id, $type, $data, $value, $validate = '1')
    {
        $value = self::removeCharacters($value);
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
                if ($validate == '1') {
                    if (!self::cpfValidator($value)) {
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
}
