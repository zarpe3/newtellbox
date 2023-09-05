<?php

namespace App\Actions\Asterisk\Inbound;

use App\Actions\ModelActionBase;
use App\Models\Inbound;
use App\Models\VoicemailUsers;

class DeleteInbound
{
    use ModelActionBase;
    protected $id;

    public function setParameters(array $data): void
    {
        $this->data = [
            'b64' => $data['b64'] ?? null,
        ];
    }

    protected function main()
    {
        if (!is_null($this->data['b64'])) {
            try {
                $inbound = json_decode(base64_decode($this->data['b64']), true);

                $inbound = Inbound::find($inbound['id']);
                VoicemailUsers::where('mailbox', $inbound->did)->delete();

                return $inbound->delete();
            } catch (\Exception $e) {
                return false;
            }
        }
    }
}
