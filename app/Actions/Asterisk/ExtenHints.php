<?php

namespace App\Actions\Asterisk;

class ExtenHints
{
    use ModelActionBase;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        $ami = new \PHPAMI\Ami();
        if ($ami->connect(
            config('service.asterisk.host').':5038',
            config('service.asterisk.ami_user'),
            config('service.asterisk.ami_pass'),
            'off'
        ) === false) {
            throw new \RuntimeException('Could not connect to Asterisk Management Interface.');
        }

        $result = $ami->command('core show channels');
        dump($result);
    }
}
