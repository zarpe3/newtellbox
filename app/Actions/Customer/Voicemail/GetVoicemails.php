<?php

namespace App\Actions\Customer\Voicemail;

use App\Actions\ModelActionBase;
use App\Models\Voicemail;
use Illuminate\Support\Facades\Storage;

class GetVoicemails
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
    }

    protected function main()
    {
        $voicemail = Voicemail::where('customer_id', $this->actionRecord->id);

        if (!$voicemail->exists()) {
            return [];
        }

        return $voicemail->get()->transform(function ($voicemail) {
            $audio = 'data:audio/mp3;base64,'.base64_encode(Storage::get($voicemail->audio));

            return [
                'name' => $voicemail->name,
                'src' => $voicemail->src,
                'dst' => $voicemail->dst,
                'created_at' => $voicemail->created_at,
                'audio' => $audio,
            ];
        });
    }
}
