<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $confirmationCode;
    public $testic;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $confirmationCode, String $testic)
    {
        //
        $this->confirmationCode = $confirmationCode;
        $this->testic = $testic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.confirmation')
            ->with([
                'code'=> strval($this->confirmationCode)
            ]);
//        return $this->markdown('emails.confirmation', [
//            'confirmationCode' => $this->confirmationCode
//        ]);
    }
}
