<div style="width: 100%; display:block;">
<h2>{{ trans('labels.EcommerceAppOrderStatus') }}</h2>
<p>
	<strong>{{ trans('labels.Hi') }} {{ $data['devices'][0]->first_name }} {{ $data['devices'][0]->last_name }}!</strong><br>
	{{ $data['message'] }}<br><br>
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ trans('labels.regardsForThanks') }}
</p>
</div>