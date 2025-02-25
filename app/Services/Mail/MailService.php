<?php

namespace App\Services\Mail;


use App\Mail\NotifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailService
{

    public function sendSimpleEmail()
    {
        $data=[
            'to' => ['abidh@interpay.sa','dattas@interpay.sa'],
            'subject' => 'Notify Email',
            'user' => Auth::user(),
        ];
        Mail::send(new NotifyEmail($data));
        return true;
    }
}