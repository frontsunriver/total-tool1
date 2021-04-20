<div style="width: 100%; display:block;">
<h2>{{ trans('labels.NewProductEmailTitle') }}</h2>
<p>
	<strong>{{ trans('labels.Hi') }} {{ $customers_data->first_name }} {{ $customers_data->last_name }}!</strong><br>
	
    {{ trans('labels.NewProductEmailPart1') }} <strong>{{$customers_data->product[0]->products_name}}</strong> {{ trans('labels.NewProductEmailPart2') }}
    <br><br>
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ trans('labels.regardsForThanks') }}
</p>
</div>