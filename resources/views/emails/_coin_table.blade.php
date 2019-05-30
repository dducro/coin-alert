@component('mail::table')
|[{{ $coin->symbol }} - {{ $coin->name }}](https://coinmarketcap.com/currencies/{{ $coin->id }}/)|{{ $coin->rank }}|
|:---|:---|
|Price eur|€ {{ $coin->price_eur }}|
|Price btc|₿ {{ $coin->price_btc }}|
|Volume eur 24h|€ {{ $coin->volume_eur_24h }}|
|Market cap eur|€ {{ $coin->market_cap_eur }}|
|Percent change 1h|{!! '<span style="color:' . ($coin->percent_change_1h >= 0 ? 'rgb(73, 199, 115);">⇧' : 'rgb(222, 88, 88);">⇩') .' '. $coin->percent_change_1h . '%</span>' !!}|
|Percent change 24h|{!! '<span style="color:' . ($coin->percent_change_24h >= 0 ? 'rgb(73, 199, 115);">⇧' : 'rgb(222, 88, 88);">⇩') .' '. $coin->percent_change_24h . '%</span>' !!}|
|Percent change 7d|{!! '<span style="color:' . ($coin->percent_change_7d >= 0 ? 'rgb(73, 199, 115);">⇧' : 'rgb(222, 88, 88);">⇩') .' '. $coin->percent_change_7d . '%</span>' !!}|
|Last updated|{{ $coin->last_updated }}|
@endcomponent
