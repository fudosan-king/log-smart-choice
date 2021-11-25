<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VerifyAccount extends Mailable
{
    use Queueable, SerializesModels;


    protected $email;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            return $this->view('emails.verify-email', ['data' => $this->data])
                ->subject(__('auth.verify_email'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

    }
}
