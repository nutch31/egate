<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestSendEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * TestSendEmail constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from($this->data["email_from"])
            ->subject($this->data["subject_mail"])
            ->to($this->data["email_to"])
            ->view('email.sendTestSendEmail')
            ->with([
                'title' => $this->data["title"],
                'content' => $this->data["content"]
            ]);
    }
}
