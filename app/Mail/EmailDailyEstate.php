<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EmailDailyEstate extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $data;
    protected $condition;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $data, $condition)
    {
        $this->email = $email;
        $this->data = $data;
        $this->condition = $condition;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            return $this->view('emails.list-estates', ['data' => $this->data, 'condition' => $this->condition])
                ->subject(__('auth.verify_email'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
