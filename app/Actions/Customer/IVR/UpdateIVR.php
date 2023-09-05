<?php

namespace App\Actions\Customer\IVR;

use App\Actions\ModelActionBase;
use App\Models\IVR;

class UpdateIVR extends IVRBase
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = [
            'id' => $data['id'] ?? false,
            'name' => $data['name'] ?? false,
            'audio' => $data['audio'] ?? false,
            'option_0' => $data['option_0'] ?? null,
            'option_1' => $data['option_1'] ?? null,
            'option_2' => $data['option_2'] ?? null,
            'option_3' => $data['option_3'] ?? null,
            'option_4' => $data['option_4'] ?? null,
            'option_5' => $data['option_5'] ?? null,
            'option_6' => $data['option_6'] ?? null,
            'option_7' => $data['option_7'] ?? null,
            'option_8' => $data['option_8'] ?? null,
            'option_9' => $data['option_9'] ?? null,
            'value_0' => $data['value_0'] ?? null,
            'value_1' => $data['value_1'] ?? null,
            'value_2' => $data['value_2'] ?? null,
            'value_3' => $data['value_3'] ?? null,
            'value_4' => $data['value_4'] ?? null,
            'value_5' => $data['value_5'] ?? null,
            'value_6' => $data['value_6'] ?? null,
            'value_7' => $data['value_7'] ?? null,
            'value_8' => $data['value_8'] ?? null,
            'value_9' => $data['value_9'] ?? null,
            'sun_start' => $data['sun_start'] ?? '00:00',
            'sun_end' => $data['sun_end'] ?? '00:00',
            'mon_start' => $data['mon_start'] ?? '00:00',
            'mon_end' => $data['mon_end'] ?? '00:00',
            'tue_start' => $data['tue_start'] ?? '00:00',
            'tue_end' => $data['tue_end'] ?? '00:00',
            'wed_start' => $data['wed_start'] ?? '00:00',
            'wed_end' => $data['wed_end'] ?? '00:00',
            'thu_start' => $data['thu_start'] ?? '00:00',
            'thu_end' => $data['thu_end'] ?? '00:00',
            'fri_start' => $data['fri_start'] ?? '00:00',
            'fri_end' => $data['fri_end'] ?? '00:00',
            'sat_start' => $data['sat_start'] ?? '00:00',
            'sat_end' => $data['sat_end'] ?? '00:00',
            'calendar' => '',
            'divert_option' => $data['divert_option'] ?? null,
            'divert_value' => $data['divert_value'] ?? null,
            'audiodivert' => $data['audio-divert'] ?? null,
        ];
    }

    protected function main()
    {
        if (!$this->data['id']) {
            throw new Exception('IVR Id not found');
        }

        $ivr = IVR::find($this->data['id']);

        if (!$ivr->exists()) {
            throw new Exception('Not a valid IVR');
        }

        unset($this->data['id']);

        $this->data['calendar'] = json_encode([
            [$this->data['sun_start'], $this->data['sun_end']],
            [$this->data['mon_start'], $this->data['mon_end']],
            [$this->data['tue_start'], $this->data['tue_end']],
            [$this->data['wed_start'], $this->data['wed_end']],
            [$this->data['thu_start'], $this->data['thu_end']],
            [$this->data['fri_start'], $this->data['fri_end']],
            [$this->data['sat_start'], $this->data['sat_end']],
        ]);

        $this->unsetCalendar();

        return $ivr->update($this->data);
    }
}
