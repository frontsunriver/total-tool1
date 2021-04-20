@if($result['order_url']=='live')
<script src="https://oppwa.com/v1/paymentWidgets.js?checkoutId={{$result['token']}}"></script>
@else
<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$result['token']}}"></script>
@endif

<form action="{{$result['webURL']}}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>