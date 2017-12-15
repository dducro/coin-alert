<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SpikeAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $coins;

    /**
     * Create a new message instance.
     *
     * @param \Illuminate\Support\Collection $coins
     */
    public function __construct(Collection $coins)
    {
        $this->coins = $coins;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.alert')
            ->with(['coins' => $this->coins]);
    }
}
