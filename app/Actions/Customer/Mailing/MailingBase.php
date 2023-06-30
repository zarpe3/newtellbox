<?php

namespace App\Actions\Customer\Mailing;

class MailingBase
{
    protected function addAccToAgents()
    {
        $accountCode = $this->actionRecord->accountcode;
        array_walk($this->data['agents'], function (&$value, $key) use ($accountCode) {
            $value = $accountCode.$value;
        });
    }
}
