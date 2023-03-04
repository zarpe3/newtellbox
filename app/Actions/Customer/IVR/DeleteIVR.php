<?php

namespace App\Actions\Customer\IVR;

use App\Actions\ModelActionBase;
use App\Models\IVR;

class DeleteIVR
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'] ?? false,
        ];
    }

    protected function main()
    {
        if (!$this->data['id']) {
            throw new Exception('IVR id not found');
        }

        return IVR::find($this->data['id'])->delete();
    }
}
