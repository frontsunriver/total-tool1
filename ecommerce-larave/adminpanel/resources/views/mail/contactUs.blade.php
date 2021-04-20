<div style="width: 100%; display:block;">
<h2>{{ trans('labels.back') }}</h2>
<p>
	<strong>
   	{{ trans('labels.HiAdmin') }}!
   	</strong><br><br>
    
	{{ trans('labels.Name') }}: {{ $data['name'] }}<br>
	{{ trans('labels.Email') }}: {{ $data['email'] }}<br><br>
	
	{{ $data['message'] }}<br><br>
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ trans('labels.ecommerceAppTeam') }}
</p>
</div>