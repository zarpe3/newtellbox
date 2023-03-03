<?php

namespace App\Actions\Asterisk;

use App\Actions\ModelActionBase;
use App\Models\SipUsers;

class SIP
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
        $this->data['onlyExtens'] = $data['onlyExtens'] ?? false;
    }

    protected function main()
    {
        if ($this->data['request'] == 'GET') {
            if ($this->checkIfThereAreRoutes()) {
                if ($this->data['onlyExtens']) {
                    return SipUsers::accountcode($this->actionRecord->accountcode)
                    ->get()
                    ->toArray();
                }

                return [
                    'success' => true,
                    'msg' => '',
                    'routes' => (new SIPRoutes())->execute($this->actionRecord, ['request' => 'GET']),
                    'extens' => SipUsers::accountcode($this->actionRecord->accountcode)
                        ->get()->toArray(),
                ];
            }

            if (!$this->checkIfThereAreRoutes()) {
                return [
                    'success' => false,
                    'routes' => [],
                    'msg' => 'Você primeiro precisa criar uma rota de saida',
                    'extens' => '',
                ];
            }
        }

        if ($this->data['request'] == 'ADD') {
            $this->data['data'] = $this->defaultSipUsersValues($this->data['data']);

            SipUsers::updateOrCreate(
                ['name' => $this->data['data']['name']],
                $this->data['data']
            );

            return response()->json(['success' => true]);
        }

        if ($this->data['request'] == 'DEL') {
            SipUsers::where('name', $this->data['name'])->delete();
        }
    }

    private function defaultSipUsersValues($data)
    {
        unset($data['id']);
        $data['type'] = 'friend';
        $data['accountcode'] = $this->actionRecord->accountcode;
        $data['callerid'] = $data['name'];
        $data['name'] = $this->actionRecord->accountcode.$data['name'];
        $data['defaultuser'] = $this->actionRecord->accountcode.$data['name'];
        $data['host'] = 'dynamic';
        $data['allow'] = 'all';
        $data['context'] = 'outbound';

        return $data;
    }

    private function checkIfThereAreRoutes()
    {
        return (new SIPRoutes())->execute($this->actionRecord, ['request' => 'EXISTS']);
    }
}
