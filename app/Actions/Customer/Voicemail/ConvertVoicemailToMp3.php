<?php

namespace App\Actions\Customer\Voicemail;

use App\Actions\ModelActionBase;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class ConvertVoicemailToMp3
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'filename' => $data['filename'] ?? '',
            'base64' => $data['base64'] ?? null,
        ];
    }

    protected function main()
    {
        if (!Storage::disk('local')->exists($this->actionRecord->accountcode)) {
            Storage::disk('local')->makeDirectory($this->actionRecord->accountcode);
        }

        if (!Storage::disk('local')->exists($this->actionRecord->accountcode.'/voicemails/')) {
            Storage::disk('local')->makeDirectory($this->actionRecord->accountcode.'/voicemails/');
        }

        Storage::disk('local')->put(
            str_replace('.mp3', '.wav', $this->actionRecord->accountcode.'/voicemails/'.$this->data['filename']),
            base64_decode($this->data['base64'])
        );

        $fullPathWav = base_path('storage/app/'
            .$this->actionRecord->accountcode
            .'/voicemails/'
            .str_replace('.mp3', '.wav', $this->data['filename']));

        $fullPathMp3 = str_replace('.wav', '.mp3', $fullPathWav);

        $command = 'ffmpeg -i '.$fullPathWav.' -acodec libmp3lame '.$fullPathMp3;
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(3600);
        $process->run();

        $process = Process::fromShellCommandline('rm -rf '.$fullPathWav);
        $process->run();
        \Log::info('rm -rf '.$fullPathWav);
    }
}
