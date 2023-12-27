<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user=$user;
    }
    /**
    *Build the mensage
    *
    * @return $this
    */
    public function build(){
        $this->subject(subject:'Redefirnir senha');        
        $this->to($this->user->email,$this->user->name); 
        $id=Hash::make($this->user->id);
        while(strstr($id,'/',true)){
            $id=Hash::make($this->user->id);
        }
        return $this->view('mailReset.sendMailReset',['destinatario'=>$this->user,'idUser'=>$id]);     
    }

}