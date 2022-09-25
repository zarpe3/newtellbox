<?php

namespace App\Actions\Customer;

use App\Actions\ModelActionBase;

class CustomerAction
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        if ($this->data['action'] == 'addPlan') {
            return $this->addPlan();
        }
    }

    protected function addPlan()
    {
        $this->actionRecord->plan = $this->data['plan'];

        return $this->actionRecord->save();
    }
}
