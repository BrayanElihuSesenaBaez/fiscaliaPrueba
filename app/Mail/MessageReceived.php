<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

    class MessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Mensaje recibido';

    public $msg;

    public function __construct($msg){
        $this->msg = $msg;
    }

    public function build(){
        return $this->view('email.message-received');
    }

}
