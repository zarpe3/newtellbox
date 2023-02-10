<?php

namespace App\Actions\Asterisk;

use App\Actions\ModelActionBase;
use Illuminate\Support\Facades\Http;

class GetTrunks
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        $response = Http::post('http://webdec-dev03.webdec.com.br/trunks/list', [
          'accountcode' => $this->actionRecord->accountcode,
        ]);
        //\Log::info($response->json());

        return $response->json();
    }
}
