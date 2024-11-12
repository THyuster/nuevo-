<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcesarCorreo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The email instance.
     *
     * @var string
     */
    protected $email;

    /**
     * The mailable instance.
     *
     * @var \Illuminate\Contracts\Mail\Mailable
     */
    protected $mailable;

    /**
     * Create a new job instance.
     *
     * @param  string  $email
     * @param  \Illuminate\Contracts\Mail\Mailable  $mailable
     * @return void
     */
    public function __construct($email, Mailable $mailable)
    {
        $this->email = $email;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send($this->mailable);
    }
}
