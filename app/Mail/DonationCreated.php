<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Donation;

class DonationCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $donation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.donation.created')
            ->with(['donation' => $this->donation]);
    }
}
