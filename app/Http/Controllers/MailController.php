<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        $objDemo = new \stdClass();
        $objDemo->token = 'token';
        $objDemo->penerima = 'rio';
 
        Mail::to("riogunawan8967uajy@gmail.com")->send(new VerificationMail($objDemo));
    }
}
