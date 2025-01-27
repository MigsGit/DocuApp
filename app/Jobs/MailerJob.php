<?php

namespace App\Jobs;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\FileInterface;



class MailerJob implements FileInterface
{

    /**
     * Execute the job.
     *
     * @return void
     */
    public function sendMailWithAttachment($mail_filename, $data, $request, $to, $cc, $subject){
        Mail::send("mail.{$mail_filename}", $data, function($message) use ($request, $to, $cc, $subject){
            $message->to($to);
            $message->cc($cc);
            $message->bcc('mclegaspi@pricon.ph');
            $message->subject($subject);
        });
    }
    //TODO : save email
    //TODO : read email
    //TODO : return to blade
    public function sendMail($mail_filename,$data, $request, $to, $cc, $subject){
        Mail::send("mail.{$mail_filename}", function($message) use ($request, $to, $cc, $subject){
            $message->to($to);
            $message->cc($cc);
            $message->bcc('mclegaspi@pricon.ph');
            $message->subject($subject);
        });
    }

}
