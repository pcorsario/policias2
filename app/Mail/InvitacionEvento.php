<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitacionEvento extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $dataInvitation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataInvitation)
    {
        $this->dataInvitation = $dataInvitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invitacion', ['invitacion' => $this->dataInvitation]);
    }
}
