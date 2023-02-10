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
            'trunkName' => str_replace(' ', '_', $data['trunk']['trunkName']),
            'username' => $data['trunk']['username'] ?? '',
            'port' => $data['trunk']['port'],
            'secret' => $data['trunk']['secret'],
            'qualify' => $data['trunk']['qualify'],
            'host' => $data['trunk']['host'],
            'transport' => $data['trunk']['transport'],
            'code' => $data['trunk']['code'],
            'context' => 'inbound',
            'accountcode' => $this->actionRecord->accountcode,
            'canreivinte' => 'yes',
            'type' => 'peer',
            'insecure' => 'invite,port',
            'callerid' => $data['trunk']['callerid'] ?? '',
            'nat' => 'force_rport,comedia',
            'allow' => 'all',
        ];
    }

    protected function main()
    {
        \Log::info(print_r($this->data, true));

        return Http::post('http://webdec-dev03.webdec.com.br/trunks/save', [
            'trunk' => $this->data['trunk'],
            'accountcode' => $this->actionRecord->accountcode,
        ]);
    }
}
