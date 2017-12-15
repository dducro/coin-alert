@component('mail::table')
|{{ $coin->symbol }} - {{ $coin->name }}| |
|:---|:---|
|Rank|{{ $coin->rank }}|
|Price usd|{{ $coin->price_usd }}|
|Price btc|{{ $coin->price_btc }}|
|Volume usd 24h|{{ $coin->volume_usd_24h }}|
|Market cap usd|{{ $coin->market_cap_usd }}|
|Available supply|{{ $coin->available_supply }}|
|Total supply|{{ $coin->total_supply }}|
|Max supply|{{ $coin->max_supply }}|
|Percent change 1h|{{ $coin->percent_change_1h }}|
|Percent change 24h|{{ $coin->percent_change_24h }}|
|Percent change 7d|{{ $coin->percent_change_7d }}|
|Last updated|{{ $coin->last_updated }}|
|Price eur|{{ $coin->price_eur }}|
|Volume eur 24h|{{ $coin->volume_eur_24h }}|
|Market cap eur|{{ $coin->market_cap_eur }}|
@endcomponent
