<div style="width: 100%; display:block;">
<h2>{{$customers_data->news[0]->news_name}}</h2>
<p>
	<strong>{{ trans('labels.Hi') }} {{ $customers_data->customers_firstname }} {{ $customers_data->last_name }}!</strong><br>
	
   <?php
   print stripslashes($customers_data->news[0]->news_description);
    ?>
    <br><br>
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ trans('labels.regardsForThanks') }}
</p>
</div>