<?php

namespace App\Actions\Asterisk\Inbound;

use App\Actions\ModelActionBase;
use App\Models\Inbound;

class GetInbound
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'] ?? null,
            'did' => $data['did'] ?? null,
        ];
    }

    protected function main()
    {
        $accountCode = $this->actionRecord->accountcode;

        $inbound = Inbound::whereHas('customer', function ($q) use ($accountCode) {
            $q->where('accountcode', $accountCode);
        });

        if (isset($this->data['id'])) {
            $inbound->where('id', $this->data['id']);
        }

        if (isset($this->data['did'])) {
            $inbound->where('did', $this->data['did']);
        }

        return $inbound->with('voicemail')->get();
    }
}
