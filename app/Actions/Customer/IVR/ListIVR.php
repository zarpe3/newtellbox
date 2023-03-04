<?php

namespace App\Actions\Customer\IVR;

use App\Actions\ModelActionBase;
use App\Models\IVR;

class ListIVR
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'name' => $data['name'] ?? false,
            'id' => $data['id'] ?? false,
        ];
    }

    protected function main()
    {
        if (!$this->data['name'] && !$this->data['id']) {
            $ivrs = $this->actionRecord::query()
            ->getAccountCode($this->actionRecord->accountcode)
            ->with('ivrs')
            ->first()
            ->toArray();

            return $ivrs['ivrs'];
        }

        $ivrs = IVR::customerId($this->actionRecord->id);
        if ($this->data['name']) {
            $ivrs->where('name', $this->data['name']);
        }

        if ($this->data['id']) {
            $ivrs->where('id', $this->data['id']);
        }

        return $ivrs->first()->toArray();
    }
}
