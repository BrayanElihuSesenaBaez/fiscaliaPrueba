<?php

namespace App\Http\Controllers;

use App\Mail\MessageReceived;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function store(){

        $message = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'content' => 'required|min:3'

        ]);
        Mail::to('hhuevod@gmail.com')->queue(new MessageReceived($message));

        return "Mensaje enviado";
    }
}
