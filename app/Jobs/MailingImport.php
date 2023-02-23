<?php

namespace App\Jobs;

use App\Actions\Customer\MailingAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MailingImport implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $mailing;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $mailing)
    {
        $this->queue = 'mailing';
        $this->mailing = $mailing;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '4095M');
        set_time_limit(0);
        
        MailingAction::import($this->mailing);
    }
}
