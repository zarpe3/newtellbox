<?php

namespace App\Imports;

use App\Models\Mailing;
use App\Models\MailingError;
use App\Models\MailingFollowUp;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MailingImport implements ToCollection
{
    private $args;
    public function __construct($args = [])
    {
        $this->args = $args;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        
        
        $line = 0;
        $collection = $collection->toArray();
        $header  = $collection[0];
        unset($collection[0]);
        
        $followUp = MailingFollowUp::find($this->args['import_id']);
        $followUp->status = 'prcessando';
        $followUp->size = count($collection);
        $followUp->success = 0;
        $followUp->fail = 0;
        $followUp->errors = 0;
        $followUp->save();
        
        $import_id = $followUp->id;
        $fail = 0;
        $import = [];
        $importErro = [];
        foreach (array_values($collection) as $row) {
            $phoneList = self::getOrderPhone($import_id, $line, $row, $header);
            $phoneError = !empty($phoneList['phoneError']) ? $phoneList['phoneError'] : [];
            foreach ($phoneError as $key => $value) {
                $importErro[] = $value;
            }
            
            if (!empty($phoneList['phoneList'])) {
                $cpf = self::validate($import_id, 'cpf', ['line' => $line, 'column' => 'cpf'], $row[6]);
                if (!$cpf['status']) {
                    $importErro[] = $cpf['message'];
                }
                
                $import[] = [
                    'phone1' => $phoneList['phoneList'][0] ?? '',
                    'phone2' => $phoneList['phoneList'][1] ?? '',
                    'phone3' => $phoneList['phoneList'][2] ?? '',
                    'phone4' => $phoneList['phoneList'][3] ?? '',
                    'phone5' => $phoneList['phoneList'][4] ?? '',
                    'name' => $row[5] ?? '',
                    'cpf' => $cpf['value'] ?? '',
                    'cod_crm' => $row[7] ?? '',
                    'user_id' => \Auth::id(),
                    'import_id' => $import_id,
                ];
            } else {
                $fail++;
            }
            
            if (count($import) >= 1000) {
                Mailing::insert($import);
                $import = [];
            }

            if (count($importErro) >= 1000) {
                MailingError::insert($importErro);
                $importErro = [];
            }

            $line++;
        }
        
        if (!empty($import)) {
            Mailing::insert($import);
        }

        if (!empty($importErro)) {
            MailingError::insert($importErro);
        }

        $followUp->status = 'finalizado';
        $followUp->success = count($import);
        $followUp->fail = $fail;
        $followUp->errors = count($importErro);
        $followUp->save();
    }
    private function getOrderPhone($import_id, $line, $row, $header)
    {
        $index = 0;
        foreach ($header as $key => $value) {
            if (str_contains($value, 'phone')) {
                $phone = self::validate($import_id, 'phone', ['line' => $line, 'column' => $value], $row[$index]);
                $phoneList[] = $phone['value'] ?? null;
                $phoneError[] = $phone['message'] ?? null;
                $index++;
            }
        }

        $phoneList = array_filter($phoneList);
        $phoneError = array_filter($phoneError);
        return [
            'phoneList' => array_values($phoneList) ?? [],
            'phoneError' => $phoneError ?? [],
        ];
    }
    private function validate($import_id, $type, $data, $value)
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
                            'value' => $value,
                            'message' => 'O telefone precisa ter mais de 10 digitos'
                        ]
                    ];
                }
                break;
            case 'cpf':
                if ($this->args['valid_cpf'] == '1') {
                    if (!self::cpf($value)) {
                        return [
                            'status' => false,
                            'message' => [
                                'teste' => $this->args['valid_cpf'],
                                'import_id' => $import_id,
                                'line' => $data['line'],
                                'column' => $data['column'],
                                'value' => $value,
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
    private function removeCharacters($string = null)
    {
        $list = [',', '.', ';', '<', '>', ':', '/', '|', '?', ']', '[', '}', '{', '(', ')',
            '=', '+', '-', '_', '"', '\'', '\\'];
        
        if (is_null($string)) {
            return null;
        }

        return trim(str_replace($list, '', $string));
    }
    private function cpf($cpf)
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
