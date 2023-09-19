<?php

namespace App\Actions\Asterisk;

use App\Actions\ModelActionBase;
use App\Models\SipUsers;
use Illuminate\Support\Facades\Http;

class SIP
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
        $this->data['onlyExtens'] = $data['onlyExtens'] ?? false;
        $this->data['onlyName'] = $data['onlyName'] ?? false;
        $this->data['webrtc'] = $data['webrtc'] ?? false;
    }

    protected function main()
    {
        if ($this->data['request'] == 'GET') {
            if ($this->checkIfThereAreRoutes()) {
                $sipUsers = SipUsers::accountcode($this->actionRecord->accountcode);

                if ($this->data['onlyName']) {
                    $extens = $sipUsers->get(['name']);
                }

                if (!$this->data['onlyName']) {
                    $extens = $sipUsers->get();
                }

                if ($this->data['onlyExtens']) {
                    return $extens->toArray();
                }

                return [
                    'success' => true,
                    'msg' => '',
                    'routes' => (new SIPRoutes())->execute($this->actionRecord, ['request' => 'GET']),
                    'extens' => $extens->toArray(),
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

            Http::post('https://webdec-dev03.webdec.com.br/sip/reload', []);

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
        $data['defaultuser'] = $data['name'];
        $data['host'] = 'dynamic';
        $data['allow'] = 'all';
        $data['context'] = 'outbound';
        $data['directmedia'] = 'yes';
        $data['dtlsenable'] = null;
        $data['dtlsverify'] = null;
        $data['dtlsprivatekey'] = null;
        $data['dtlscertfile'] = null;
        $data['dtlssetup'] = null;
        $data['icesupport'] = null;
        $data['avpf'] = null;
        $data['rtcp_mux'] = null;

        if ($data['webrtc'] == 'yes') {
            $data['dtlsenable'] = 'yes';
            $data['dtlsverify'] = 'fingerprint';
            $data['dtlsprivatekey'] = '/etc/letsencrypt/live/webdec-dev03.webdec.com.br/privkey.pem';
            $data['dtlscertfile'] = '/etc/letsencrypt/live/webdec-dev03.webdec.com.br/cert.pem';
            $data['dtlssetup'] = 'actpass';
            $data['icesupport'] = 'yes';
            $data['avpf'] = 'yes';
            $data['rtcp_mux'] = 'yes';
        }

        unset($data['webrtc']);

        return $data;
    }

    private function checkIfThereAreRoutes()
    {
        return (new SIPRoutes())->execute($this->actionRecord, ['request' => 'EXISTS']);
    }
}
