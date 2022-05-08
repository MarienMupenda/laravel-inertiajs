<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    public $name;
    public $subject;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$name,$subject,$data)
    {
        //
        $this->email=$email;
        $this->name=$name;
        $this->subject=$subject;
        $this->data=$data;

        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email=$this->email;
        $name=$this->name;
        $subject=$this->subject;
    
        Mail::send('mail', $this->data, function($message) use ($email,$name,$subject) {
            $message->to($email,$name)->subject
               ($subject);
            $message->from(env('MAIL_FROM_ADDRESS'),env('APP_NAME'));

        });
    }    
}
