<?php

namespace App\Actions\Customer\Audios;

use App\Actions\ModelActionBase;
use Exception;
use Symfony\Component\Process\Process;

class ConvertAudioToSLN
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'filePath' => $data['filePath'] ?? '',
            'fileName' => $data['fileName'] ?? '',
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
            $file = $this->data['filePath'].'/'.$this->data['fileName'];
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            $newFile = str_replace('.'.$extension, '.sln', $file);

            //// ffmpeg -i “[input file]” -ar 8000 -ac 1 -acodec pcm_s16le -f s16le “[output file].sln”
            $command = 'ffmpeg -i '.$file.' -ar 8000 -ac 1 -acodec pcm_s16le -f s16le '.$newFile;
            $process = Process::fromShellCommandline($command);
            $process->run();

            $process = Process::fromShellCommandline('rm -rf '.$file);
            $process->run();

            return $newFile;
        } catch (Exception $e) {
            \Log::info($e->getMessage());

            return '';
        }
    }
}
