<?php

namespace App\Actions\Customer;

use App\Actions\ActionBase;
use App\Models\Customer;
use Log;

class AvailableAccountCode
{
    use ActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        $accountcode = 0;
        $min = 23400000;
        $maxAccountCode = Customer::max('accountcode');

        if ($maxAccountCode > $min) {
            $accountcode = $maxAccountCode;
        }

        if ($maxAccountCode <= $min) {
            $accountcode = $min;
        }

        while ($this->checkRepeatedAcc($accountcode)) {
            ++$accountcode;
        }

        Log::info($accountcode);

        return $accountcode;
    }

    protected function checkRepeatedAcc($accountcode)
    {
        return Customer::where('accountcode', $accountcode)->exists();
    }
}
