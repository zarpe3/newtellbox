<?php

namespace App\Jobs;

use App\Actions\Customer\Audios\ConvertAudioToSLN;
use App\Actions\Customer\Audios\SendAudioToAS;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class ConvertAudioToAS implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $file;
    private $accountCode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $file, string $accountCode)
    {
        $this->file = $file;
        $this->accountCode = $accountCode;
    }

    /**
     * Execute the job to convert the audio into Asterisk format.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $storage = Storage::disk('local');
            $customer = Customer::where('accountcode', $this->accountCode);

            if (!$customer->exists()) {
                throw new Exception('Not valid accountCode', 1);
            }

            $customer = $customer->first();
            if ($storage->exists($this->file)) {
                $filePath = storage_path('app/'.dirname($this->file));
                $fileName = basename($this->file);
                $audioSLN = (new ConvertAudioToSLN())->execute($customer, [
                    'filePath' => $filePath,
                    'fileName' => $fileName,
                ]);

                (new SendAudioToAS())->execute($customer, ['audio' => $audioSLN]);
            }
        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }
}
