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

        if ($this->data['action'] == 'updateVoicemailNotify') {
            return $this->updateVoicemailNotify();
        }
    }

    protected function updateVoicemailNotify()
    {
        $this->actionRecord->notify_voicemail = $this->data['notify_voicemail'];

        return $this->actionRecord->save();
    }

    protected function addPlan()
    {
        $this->actionRecord->plan = $this->data['plan'];

        return $this->actionRecord->save();
    }
}
