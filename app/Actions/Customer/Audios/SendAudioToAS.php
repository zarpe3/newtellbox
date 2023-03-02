<?php

namespace App\Actions\Customer\Audios;

use App\Actions\ModelActionBase;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SendAudioToAS
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'audio' => $data['audio'], //// path + audio
        ];
    }

    /**
     * This method converts the audio file into base64 and send to API to Asterisk.
     *
     * @return void
     */
    protected function main()
    {
        $file = $this->prunningAddress($this->data['audio']);
        $storage = Storage::disk('local');
        if ($storage->has($file)) {
            $base64 = base64_encode($storage->get($file));
            $fileName = basename(storage_path('app/'.$file));

            return Http::post('http://webdec-dev03.webdec.com.br/saveAudio', [
                'base64' => $base64,
                'fileName' => $fileName,
                'accountcode' => $this->actionRecord->accountcode,
            ]);
        }

        throw new Exception('Audio file not found', 1);
    }

    protected function prunningAddress($audio)
    {
        return str_replace(storage_path().'/app/', '', $audio);
    }
}
