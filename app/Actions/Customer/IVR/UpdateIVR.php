<?php

namespace App\Actions\Customer\IVR;

use App\Actions\ModelActionBase;
use App\Models\IVR;

class UpdateIVR
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'] ?? false,
            'name' => $data['name'] ?? false,
            'audio' => $data['audio'] ?? false,
            'option_0' => $data['option_0'] ?? null,
            'option_1' => $data['option_1'] ?? null,
            'option_2' => $data['option_2'] ?? null,
            'option_3' => $data['option_3'] ?? null,
            'option_4' => $data['option_4'] ?? null,
            'option_5' => $data['option_5'] ?? null,
            'option_6' => $data['option_6'] ?? null,
            'option_7' => $data['option_7'] ?? null,
            'option_8' => $data['option_8'] ?? null,
            'option_9' => $data['option_9'] ?? null,
            'value_0' => $data['value_0'] ?? null,
            'value_1' => $data['value_1'] ?? null,
            'value_2' => $data['value_2'] ?? null,
            'value_3' => $data['value_3'] ?? null,
            'value_4' => $data['value_4'] ?? null,
            'value_5' => $data['value_5'] ?? null,
            'value_6' => $data['value_6'] ?? null,
            'value_7' => $data['value_7'] ?? null,
            'value_8' => $data['value_8'] ?? null,
            'value_9' => $data['value_9'] ?? null,
            'divert_option' => $data['divert_option'] ?? null,
            'divert_value' => $data['divert_value'] ?? null,
        ];
    }

    protected function main()
    {
        if (!$this->data['id']) {
            throw new Exception('IVR Id not found');
        }

        $ivr = IVR::find($this->data['id']);

        if (!$ivr->exists()) {
            throw new Exception('Not a valid IVR');
        }

        unset($this->data['id']);

        return $ivr->update($this->data);
    }
}
