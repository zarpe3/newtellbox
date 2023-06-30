<?php

namespace App\Actions\Customer;

use App\Actions\ModelActionBase;
use App\Traits\Asm;

class ReceptionConsole
{
    use ModelActionBase;
    use Asm;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        if ($this->data['request'] == 'HANGUP') {
            $this->hangup();
        }

        if ($this->data['request'] == 'SPY') {
            $this->spy();
        }

        if ($this->data['request'] == 'TRANSFER') {
            $this->transfer();
        }
    }

    protected function hangup()
    {
        if ($this->connect()) {
            $response = $this->asm->hangup($this->data['channel']);

            if ($response['Response'] == 'Success') {
                return response()->json([
                    'success' => true,
                    'message' => $response['Message'],
                ]);
            }

            $this->asm->disconnect();

            return response()->json([
                'success' => false,
                'message' => 'failed to hangup',
            ]);
        }
    }

    protected function spy()
    {
        if ($this->connect()) {
            $response = $this->asm->originate(
                'Local/'.$this->data['exten'].'@spy-dial/n',
                's',
                'spy',
                1,
                null,
                null,
                300000,
                'Spy - '.$this->data['exten'],
                'SPYCHANNEL='.$this->data['channel'].',MODE=whisper',
                $this->actionRecord->accountcode,
                uniqid()
            );

            $this->asm->disconnect();

            return response()->json([
                'success' => false,
                'message' => 'failed to hangup',
            ]);
        }
    }

    protected function transfer()
    {
        if ($this->connect()) {
            $response = $this->asm->Status($this->data['channel']);
            $allChannels = $this->asm->send_request('Status', []);

            if (array_key_exists('events', $response)) {
                $myBridgeId = $response['events'][0]['BridgeID'];
            }

            foreach ($allChannels['events'] as $channel) {
                if ($channel['BridgeID'] == $myBridgeId && $channel['Channel'] != $this->data['channel']) {
                    $response = $this->asm->Redirect($channel['Channel'], null, $this->data['exten'], 'inbound', 1);
                }
            }

            if ($response['Response'] == 'Success') {
                return response()->json([
                    'success' => true,
                    'message' => $response['Message'],
                ]);
            }

            $this->asm->disconnect();

            return response()->json([
                'success' => false,
                'message' => 'failed to transfer',
            ]);
        }
    }
}
