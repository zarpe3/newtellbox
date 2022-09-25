<?php

namespace App\Actions\Asterisk;

use App\Actions\ModelActionBase;
use Illuminate\Support\Facades\Http;

class UpdateTrunks
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data['trunk'] = [
            'trunkName' => $data['trunk']['trunkName'],
            'port' => $data['trunk']['port'],
            'secret' => $data['trunk']['secret'],
            'qualify' => $data['trunk']['qualify'],
            'host' => $data['trunk']['host'],
            'transport' => $data['trunk']['transport'],
            'code' => $data['trunk']['code'],
            'context' => 'inbound',
            'canreivinte' => 'yes',
            'type' => 'peer',
            'insecure' => 'yes',
            'nat' => 'force_rport,comedia',
            'allow' => 'all',
        ];
    }

    protected function main()
    {
        return Http::post('http://webdec-dev03.webdec.com.br/trunks/save', [
            'trunk' => $this->data['trunk'],
            'accountcode' => $this->actionRecord->accountcode,
        ]);
    }
}
