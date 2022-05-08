<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;
use Mail;

class ReceivedPaymentJob implements ShouldQueue
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
        $this->paymentId=$paymentId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $paymentId=$this->paymentId;
        $payment=Payment::where('id',$paymentId)->first();
        
        if (!$payment->email ==null) {
            $email=$payment->email;
            $name=$payment->email;
            $subject="Paiement reçus";
            $data=[
            'name'=>$payment->email,
            'body'=>"Votre achat a été effectuer avec succès,\n
            paiment de $payment->amount $payment->currency \n, 
            Transaction ID: $payment->transaction_id \n, 
            Ref: $payment->financial_institution_id"

        ];
            Mail::send('mail', $data, function ($message) use ($email, $name, $subject) {
                $message->to($email, $name)->subject($subject);
                $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            });
            \Log::info("Email send for payment ".$payment->reference);

        }
    }
}
