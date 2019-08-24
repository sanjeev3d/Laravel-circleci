<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;

class EmailController extends Controller
{
    public static function VerifyMail($user)
    {
        Mail::to($user->email)->send(new VerifyMail($user));
    }
}
