<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ModelActionBase;

class GetOrderPhone
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'header' => $data['header'],
            'import_id' => $data['import_id'],
            'line' => $data['line'],
            'row' => $data['row'],
        ];
    }

    protected function main()
    {
        $index = 0;
        $phoneList = $phoneError = [];
        foreach ($this->data['header'] as $key => $value) {
            if (str_contains($value, 'phone')) {
                $phone = (new Validate())->execute($this->actionRecord, [
                    'import_id' => $this->data['import_id'],
                    'type' => 'phone',
                    'data' => ['line' => $this->data['line'], 'column' => $value],
                    'value' => $this->data['row'][$index],
                ]);
                $phoneList[] = $phone['value'] ?? '';
                $phoneError[] = $phone['message'] ?? '';
                ++$index;
            }
        }

        $phoneList = array_filter($phoneList);
        $phoneError = array_filter($phoneError);

        if (!empty($phoneError)) {
            $phoneError = array_values(
                (new MergeErrors())->execute($this->actionRecord, ['importError' => $phoneError])
            );
        }

        return [
            'phoneList' => array_values($phoneList) ?? [],
            'phoneError' => $phoneError[0] ?? null,
        ];
    }
}
