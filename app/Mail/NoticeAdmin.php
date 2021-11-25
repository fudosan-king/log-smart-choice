<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NoticeAdmin extends Mailable
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
            return $this->view('emails.notice_admin_after_customer_register', ['data' => $this->data])
                ->subject(__('customer.notice_admin_subject'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
