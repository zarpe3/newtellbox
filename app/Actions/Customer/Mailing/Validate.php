<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ModelActionBase;
use App\Traits\Helper;

class Validate
{
    use ModelActionBase;
    use Helper;

    public function setParameters(array $data): void
    {
        $this->data = [
            'import_id' => $data['import_id'],
            'type' => $data['type'],
            'data' => $data['data'],
            'value' => $data['value'],
            'validate' => $data['validate'] ?? '1',
        ];
    }

    protected function main()
    {
        $value = $this->removeCharacters($this->data['value']);
        switch ($this->data['type']) {
            case 'phone':
                if (strlen($value) < 10 || empty(trim($value))) {
                    return [
                        'status' => false,
                        'message' => [
                            'import_id' => $this->data['import_id'],
                            'line' => $this->data['data']['line'],
                            'column' => $this->data['data']['column'],
                            'value' => '',
                            'message' => 'O telefone precisa ter mais de 10 digitos',
                        ],
                    ];
                }
                break;
            case 'cpf':
                if ($this->data['validate'] == '1') {
                    if (!$this->cpfValidator($value)) {
                        return [
                            'status' => false,
                            'message' => [
                                'import_id' => $this->data['import_id'],
                                'line' => $this->data['data']['line'],
                                'column' => $this->data['data']['column'],
                                'value' => !empty($value) ? $value : '',
                                'message' => 'cpf inválido',
                            ],
                        ];
                    }
                }
                break;
        }

        return [
            'status' => true,
            'value' => $value,
        ];
    }
}
