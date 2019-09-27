<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestSendEmail;
use Illuminate\Support\Facades\Mail;


class TestController extends Controller
{
    //
    public function testSendEmail()
    {
        $data = [
            'email_from' => 'egate.website@gmail.com',
            'email_to' => ['nutnutnutnutnutnutnutnutnutnut@gmail.com'],
            'subject_mail' => 'Test System',
            'title' => 'Test Title',
            'content' => 'Test Content'
        ];

        Mail::send(new TestSendEmail($data));
    }
}
