<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;
use Http;
use DB;


class PaymentCallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $paymentId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($paymentId)
    {
        //
        $paymentId=$this->paymentId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->paymentId=$paymentId;

        $payment=Payment::where('id',$paymentId)
        ->first();
        if($payment!=null){


        }
    }
}
