<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ModelActionBase;

class MergeErrors
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'importError' => $data['importError'],
        ];
    }

    protected function main()
    {
        $data = [];

        $column = $message = $valueString = '';

        foreach (array_filter($importError) as $key => $value) {
            $column .= "{$value['column']},";
            $message .= "{$value['message']},";
            $valueString .= "{$value['value']},";
            $data[$value['line']] = [
                'import_id' => $value['import_id'],
                'line' => $value['line'],
                'column' => $column,
                'value' => $valueString,
                'message' => $message,
            ];
        }

        return $data;
    }
}
