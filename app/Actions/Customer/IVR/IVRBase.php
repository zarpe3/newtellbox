<?php

namespace App\Actions\Customer\IVR;

class IVRBase
{
    protected function unsetCalendar()
    {
        unset(
            $this->data['sun_start'],
            $this->data['sun_start'],
            $this->data['sun_end'],
            $this->data['mon_start'],
            $this->data['mon_end'],
            $this->data['tue_start'],
            $this->data['tue_end'],
            $this->data['wed_start'],
            $this->data['wed_end'],
            $this->data['thu_start'],
            $this->data['thu_end'],
            $this->data['fri_start'],
            $this->data['fri_end'],
            $this->data['sat_start'],
            $this->data['sat_end']
        );
    }
}
