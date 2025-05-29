<?php

namespace App\Jobs;

use App\Mail\ReservationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReservationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reservation;
    /**
     * Create a new job instance.
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->reservation->user) {
            Mail::to($this->reservation->user->email)->send(new ReservationMail($this->reservation));
        } else {
            Mail::to($this->reservation->guest->email)->send(new ReservationMail($this->reservation));
        }
    }
}
