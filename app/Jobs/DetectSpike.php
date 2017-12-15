<?php

namespace App\Jobs;

use App\Coin;
use App\Mail\SpikeAlert;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class DetectSpike implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private $minPercentChanged;

    /**
     * @var int
     */
    private $count;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $endpoint = 'https://api.coinmarketcap.com/v1/ticker/?';

    /**
     * DetectSpike constructor.
     *
     * @param int    $minPercentChanged
     * @param int    $count
     * @param string $currency
     */
    public function __construct($minPercentChanged = 7, $count = 100, $currency = 'EUR')
    {
        $this->minPercentChanged = $minPercentChanged;
        $this->count             = $count;
        $this->currency          = $currency;
    }

    /**
     * @param \GuzzleHttp\Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        $query = [
            'convert' => $this->currency,
            'limit'   => $this->count
        ];

        $url = $this->endpoint . http_build_query($query);

        $response = json_decode($client->get($url)->getBody()->getContents(), true);

        $coins = collect($response)
            ->map(function ($data) {
                $coin                 = (new Coin)->forceFill($data);
                $coin->volume_usd_24h = $data['24h_volume_usd'];
                $coin->volume_eur_24h = $data['24h_volume_eur'];

                return $coin;
            })
            ->filter(function (Coin $coin) {
                return abs($coin->percent_change_1h) >= $this->minPercentChanged;
            })
            ->filter(function (Coin $coin) {
                return cache()->add($coin->id, 1, 60);
            });

        if ($coins->count()) {
            Mail::to(config('alert.recipients'))
                ->send(new SpikeAlert($coins));
        }
    }
}
