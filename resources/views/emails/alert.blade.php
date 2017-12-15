@component('mail::message')
## The following coins are experiencing heavy price action.

@foreach($coins as $coin)
@include('emails._coin_table')
@endforeach

@component('mail::button', ['url' => 'https://coinmarketcap.com'])
    GO TO COINMARKETCAP
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
