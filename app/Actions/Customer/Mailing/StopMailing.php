<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ModelActionBase;
use App\Models\MailingFollowUp;

class StopMailing
{
    use ModelActionBase;

    /**
     * setParameters.
     *
     * @param array data
     */
    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'] ?? null,
        ];
    }

    /**
     * main.
     *
     * @return void
     */
    protected function main()
    {
        MailingFollowUp::where(['customer_id' => $this->actionRecord->id])
            ->where('_id', $this->data['id'])
            ->update([
                'status' => 'pausado',
            ]);

        return response()->json(['success' => true]);
    }
}
