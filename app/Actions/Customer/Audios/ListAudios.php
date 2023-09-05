<?php

namespace App\Actions\Customer\Audios;

use App\Actions\ModelActionBase;
use Exception;
use Illuminate\Support\Facades\Http;

class ListAudios
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
    }

    /**
     * This method converts the audio into asterisk file format SLN.
     *
     * @return void
     */
    protected function main(): array
    {
        try {
            return str_replace(
                'recording/'.$this->actionRecord->accountcode.'/',
                '',
                json_decode(Http::post('https://webdec-dev03.webdec.com.br/listAudio', [
                    'accountcode' => $this->actionRecord->accountcode,
                ]), true)
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
