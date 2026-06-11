<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public Mailable $mailable
    ) {}

    public function handle(): void
    {
        Mail::to($this->email)->send($this->mailable);
    }
}
