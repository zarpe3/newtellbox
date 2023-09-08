<?php

namespace App\Actions\CGrates;

use App\Actions\ModelActionBase;

class Test
{
    use ModelActionBase;
    use Connect;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
    }
}
