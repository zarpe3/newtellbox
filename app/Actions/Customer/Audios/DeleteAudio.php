<?php

namespace App\Actions\Customer\Audios;

use App\Actions\ModelActionBase;
use Exception;
use Illuminate\Support\Facades\Http;

class DeleteAudio
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'fileName' => $data['fileName'] ?? null,
        ];
    }

    /**
     * This method converts the audio into asterisk file format SLN.
     *
     * @return void
     */
    protected function main(): bool
    {
        try {
            if (!isset($this->data['fileName'])) {
                throw new Exception('File name is mandatory', 1);
            }

            Http::post('http://webdec-dev03.webdec.com.br/deleteAudio', [
                    'accountcode' => $this->actionRecord->accountcode,
                    'fileName' => $this->data['fileName'],
            ]);

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
