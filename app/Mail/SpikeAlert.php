<?php

namespace App\Mail;

use App\Coin;
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
        $subject = $this->coins->map(function (Coin $coin) {
            return ($coin->is_positive ? '⇧' : '⇩') . ' ' . $coin->symbol;
        })->implode(' ');

        return $this
            ->subject($subject)
            ->markdown('emails.alert')
            ->with(['coins' => $this->coins]);
    }
}
