<?php

namespace App\Actions\Asterisk;

use App\Actions\ModelActionBase;
use Illuminate\Support\Facades\Http;

class DeleteTrunks
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'trunkName' => $data['trunkName'] ?? 'unset',
        ];
    }

    protected function main()
    {
        return Http::post('https://webdec-dev03.webdec.com.br/trunks/delete', [
            'trunkName' => $this->data['trunkName'],
            'accountcode' => $this->actionRecord->accountcode,
        ]);
    }
}
