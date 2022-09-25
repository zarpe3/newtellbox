<?php

namespace App\Actions\Customer;

use App\Actions\ModelActionBase;
use App\Models\CDR;

class GetCDR
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        return CDR::accountCode($this->actionRecord->accountcode)->get();
    }
}
