<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ModelActionBase;

class WriteMailingError
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'now' => $data['now'],
            'importError' => $data['importError'],
        ];
    }

    protected function main()
    {
        $file_path = storage_path("app/{$this->actionRecord->accountcode}/tmp/");
        if (!file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }

        $file_path = "{$file_path}{$this->data['now']}-error.csv";
        $file_handle = fopen($file_path, 'w');
        $file_handle = fopen($file_path, 'a+');

        foreach ($this->data['importError'] as $line) {
            $line = "{$line['line']},{$line['column']},{$line['value']},{$line['message']}";
            fwrite($file_handle, $line."\n");
        }

        fclose($file_handle);

        return $file_path;
    }
}
