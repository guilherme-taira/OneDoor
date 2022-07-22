<?php

namespace App\Jobs;

use App\Http\Controllers\Order\sendOrderQueueController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendOrcamentoViaApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     private $ORCNUM;

    public function __construct($ORCNUM)
    {
        $this->ORCNUM = $ORCNUM;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request = new sendOrderQueueController($this->getORCNUM());
        $request->resource();
    }

     /**
      * Get the value of ORCNUM
      */
     public function getORCNUM()
     {
          return $this->ORCNUM;
     }
}
