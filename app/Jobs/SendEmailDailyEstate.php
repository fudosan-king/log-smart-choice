<?php

namespace App\Jobs;

use App\Mail\EmailDailyEstate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailDailyEstate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $receiver;
    protected $data;
    protected $condition;
    protected $customer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customer, $data, $condition)
    {
        $this->receiver = $customer->email;
        $this->data = $data;
        $this->condition = $condition;
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $email = new EmailDailyEstate($this->receiver, $this->data, $this->condition, $this->customer);
            Mail::to($this->receiver)->send($email);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
