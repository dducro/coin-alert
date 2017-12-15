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
    public function __construct($minPercentChanged = 8, $count = 100, $currency = 'EUR')
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
            ->map([$this, 'map'])
            ->filter([$this, 'filter'])
            ->filter([$this, 'cache']);

        if ($coins->count()) {
            Mail::to(config('alert.recipients'))
                ->send(new SpikeAlert($coins));
        }
    }

    /**
     * @param \App\Coin $coin
     * @return bool
     */
    public function filter(Coin $coin)
    {
        if (abs($coin->percent_change_1h) >= $this->minPercentChanged) {
            if (($coin->percent_change_1h > 0 && $coin->percent_change_24h > 0) ||
                ($coin->percent_change_1h < 0 && $coin->percent_change_24h < 0)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $data
     * @return \App\Coin
     */
    public function map(array $data)
    {
        $coin                 = (new Coin)->forceFill($data);
        $coin->volume_usd_24h = $data['24h_volume_usd'];
        $coin->volume_eur_24h = $data['24h_volume_eur'];

        return $coin;
    }

    /**
     * @param \App\Coin $coin
     * @return bool
     * @throws \Exception
     */
    public function cache(Coin $coin)
    {
        return cache()->add($coin->id, 1, 60);
    }

}
