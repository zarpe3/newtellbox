<?php

namespace App\Actions\Customer\Files;

use App\Actions\ModelActionBase;
use Exception;
use Illuminate\Support\Facades\Storage;

class StoreTmpFile
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'file' => $data['file'] ?? null,
            'newName' => $data['newName'] ?? null,
        ];
    }

    protected function main(): string
    {
        if (!isset($this->data['file'])) {
            throw new Exception('No file to be stored', 1);
        }

        if ($this->data['file']->isValid()) {
            if (!Storage::disk('local')->exists($this->actionRecord->accountcode)) {
                Storage::disk('local')->makeDirectory($this->actionRecord->accountcode);
            }

            if (!Storage::disk('local')->exists($this->actionRecord->accountcode.'/tmp/')) {
                Storage::disk('local')->makeDirectory($this->actionRecord->accountcode.'/tmp/');
            }

            $fileName = $this->data['file']->getClientOriginalName();
            if (isset($this->data['newName'])) {
                $fileName = $this->data['newName'].'.'.$this->data['file']->extension();
            }

            $this->data['file']->storeAs($this->actionRecord->accountcode.'/tmp/', $fileName);

            return $this->actionRecord->accountcode.'/tmp/'.$fileName;
        }

        throw new Exception('Not valid file', 1);
    }
}
