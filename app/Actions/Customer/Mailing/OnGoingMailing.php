<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ActionBase;
use App\Models\Mailing as Phones;

class OnGoingMailing
{
    use ActionBase;

    /**
     * setParameters.
     *
     * @param array data
     */
    public function setParameters(array $data): void
    {
        $this->data = [
            'campaign_id' => $data['campaign_id'] ?? null,
            'id' => $data['id'],
            'phones' => $data['phones'],
        ];
    }

    /**
     * main.
     *
     * @return void
     */
    protected function main()
    {
        \Log::info(print_r($this, true));
        $mailings = Phones::where('campaign_id', $this->data['campaign_id'])
            ->where('_id', $this->data['id'])
            ->whereIn('phones.phone', $this->data['phones'])
            ->where('phones.status', '<>', 100)
            ->get();

        foreach ($mailings as $m) {
            \Log::info(print_r($m, true));
            $id = $m->_id;
            $phones = $m->phones;

            foreach ($phones as &$phone) {
                if (in_array($phone['phone'], $this->data['phones'])) {
                    $phone['status'] = 100;
                    $phone['attempts'] = $phone['attempts'] + 1;
                }
            }

            Phones::where('campaign_id', $this->data['campaign_id'])
                ->where('_id', $this->data['id'])
                ->where('phones.status', '<>', 100)
                ->update([
                    'phones' => $phones,
                    'status' => 100,
                ]);
        }

        response()->json(['success' => true]);
    }
}
