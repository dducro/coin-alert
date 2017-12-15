@component('mail::table')
|[{{ $coin->symbol }} - {{ $coin->name }}](https://coinmarketcap.com/currencies/{{ $coin->id }}/)|{{ $coin->rank }}|
|:---|:---|
|Price eur|€ {{ $coin->price_eur }}|
|Price btc|₿ {{ $coin->price_btc }}|
|Volume eur 24h|{{ $coin->volume_eur_24h }}|
|Market cap eur|{{ $coin->market_cap_eur }}|
|Percent change 1h|{{ $coin->percent_change_1h }}|
|Percent change 24h|{{ $coin->percent_change_24h }}|
|Percent change 7d|{{ $coin->percent_change_7d }}|
|Last updated|{{ $coin->last_updated }}|
@endcomponent
