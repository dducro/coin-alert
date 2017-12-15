<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Coin
 *
 * @package App
 * @property string $id
 * @property string $name
 * @property string $symbol
 * @property int    $rank
 * @property float  $price_usd
 * @property float  $price_btc
 * @property float  $volume_usd_24h
 * @property float  $market_cap_usd
 * @property float  $available_supply
 * @property float  $total_supply
 * @property float  $max_supply
 * @property float  $percent_change_1h
 * @property float  $percent_change_24h
 * @property float  $percent_change_7d
 * @property float  $last_updated
 * @property float  $price_eur
 * @property float  $volume_eur_24h
 * @property float  $market_cap_eur
 */
class Coin extends Model
{
    protected $table = 'coins';
}
