<?php

namespace App\Traits;

trait Asm
{
    public $asm;

    public function connect()
    {
        $this->asm = new \AGI_AsteriskManager();
        $host = config('services.asterisk.host').':5038';
        if ($this->asm->connect($host, config('services.asterisk.ami_user'), config('services.asterisk.ami_pass'))) {
            return true;
        }

        return false;
    }
}
