<?php

namespace App\Actions\Customer\Audios;

use App\Actions\Customer\Files\StoreTmpFile;
use App\Actions\ModelActionBase;
use App\Jobs\ConvertAudioToAS;
use Exception;

class SaveAudio
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'file' => $data['file'],
            'name' => $data['name'],
        ];
    }

    /**
     * This method converts the audio into asterisk file format SLN.
     *
     * @return void
     */
    protected function main(): string
    {
        try {
            $newName = $this->removeChars($this->data['name']);
            $tmpAudio = (new StoreTmpFile())->execute($this->actionRecord, [
                'file' => $this->data['file'],
                'newName' => $newName,
            ]);
            ConvertAudioToAS::dispatch($tmpAudio, $this->actionRecord->accountcode)->delay(now()->addSeconds(3));

            return $tmpAudio;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function removeChars($name)
    {
        $string = str_replace(' ', '-', $name);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $name);
    }
}
