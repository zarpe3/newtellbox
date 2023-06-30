<?php

namespace App\Jobs;

use App\Actions\Customer\Mailing\OnGoingMailing as OnGoing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OnGoingMailing implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $campaignId;
    private $phones;
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaignId, $phones, $id)
    {
        $this->campaignId = $campaignId;
        $this->phones = $phones;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new OnGoing())->execute([
            'campaign_id' => $this->campaignId,
            'phones' => $this->phones,
            'id' => $this->id,
        ]);
    }
}
