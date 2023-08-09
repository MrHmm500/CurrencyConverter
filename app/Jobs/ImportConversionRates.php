<?php

namespace App\Jobs;

use App\Models\ConversionBase;
use App\Models\ConversionRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportConversionRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $conversions)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $base = ConversionBase::create([
            'base' => $this->conversions['base'],
            'date' => $this->conversions['date']
        ]);

        foreach ($this->conversions['rates'] as $currency => $rate) {
            ConversionRate::create([
                'conversion_base_id' => $base->id,
                'currency' => (string) $currency,
                'rate' => $rate == 'NaN' ? 0 : $rate
            ]);
        }
    }
}
