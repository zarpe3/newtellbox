<?php

namespace App\Actions\Asterisk\Queue;

use App\Models\QueueMember;

class BaseQueue
{
    protected function setAgents($agents, $name)
    {
        foreach ($agents as $agent) {
            QueueMember::create([
                'uniqueid' => abs(crc32(uniqid())),
                'membername' => 'Local/'.$agent.'@queue_out/n',
                'queue_name' => $name,
                'interface' => 'Local/'.$agent.'@queue_out/n',
            ]);
        }
    }
}
