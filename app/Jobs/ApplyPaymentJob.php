<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ReceivedPaymentJob;
use App\Jobs\SendEmailJob;
use App\Models\Payment;

class ApplyPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $financial_institution_id;

    public $paymentId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($paymentId, $financial_institution_id)
    {
        //
        $this->paymentId=$paymentId;

        $this->financial_institution_id=$financial_institution_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $paymentId=$this->paymentId;
        $financial_institution_id=$this->financial_institution_id;

        $payment=Payment::where('id', $paymentId)
        ->update([
            'state'=>'done',
            'financial_institution_id'=>$financial_institution_id,
            'payment_date'=> now(),
        ]);

        //
    }
}
