<div style="width: 100%; display:block;">
<h2>{{ trans('labels.WelcomeEamailTitle') }}</h2>
<p>
	<strong>{{ trans('labels.Hi') }} {{ $userData[0]->first_name }} {{ $userData[0]->last_name }}!</strong><br>
	{{ trans('labels.accountCreatedText') }}<br><br>
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ trans('labels.regardsForThanks') }}
</p>
</div>