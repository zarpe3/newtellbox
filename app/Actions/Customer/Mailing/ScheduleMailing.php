<?php

namespace App\Actions\Customer\Mailing;

use App\Actions\ActionBase;
use Carbon\Carbon;

class ScheduleMailing
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
            'dialstatus' => $data['dialstatus'] ?? null,
        ];
    }

    /**
     * main.
     *
     * @return void
     */
    protected function main()
    {
        switch ($this->data['dialstatus']) {
            case 'ANSWER':
                return ['status' => 300, 'schedule' => ''];
                break;
            case 'BUSY':
                return ['status' => 200, 'schedule' => Carbon::now()->addMinutes(5)->toDateTimeString()];
                break;
            case 'NOANSWER':
                return ['status' => 200, 'schedule' => Carbon::now()->addMinutes(35)->toDateTimeString()];
                break;
            case 'CANCEL':
                return ['status' => 200, 'schedule' => Carbon::now()->addMinutes(35)->toDateTimeString()];
                break;
            case 'CONGESTION':
                return ['status' => 200, 'schedule' => Carbon::now()->addMinutes(35)->toDateTimeString()];
                break;
            case 'CHANUNAVAIL':
                return ['status' => 200, 'schedule' => Carbon::now()->addMinutes(35)->toDateTimeString()];
                break;
            case 'DROP':
                return ['status' => 200, 'schedule' => Carbon::now()->addMinutes(60)->toDateTimeString()];
                break;
        }
    }
}
