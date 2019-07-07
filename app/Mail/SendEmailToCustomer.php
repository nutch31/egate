<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $email_from;
    public $lead;
    public $campaign;

    /**
     * SendEmailToCustomer constructor.
     * @param $email_from
     * @param $lead
     * @param $campaign
     */
    public function __construct($email_from, $lead, $campaign)
    {
        //
        $this->email_from = $email_from;
        $this->lead = $lead;
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email_from)
                    ->view('email.sendEmailToCustomer')
                    ->with([
                        "lead", $this->lead,
                        "campaign", $this->campaign
                    ]);
    }
}
