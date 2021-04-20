@if (isset($data['deliveryboys']))
@foreach ($data['deliveryboys'] as $key=>$deliveryboy)
@if($deliveryboy->is_seen == 0)
<tr>
    <td>{{ $deliveryboy->id }}</td>
    <td>
        {{ $deliveryboy->first_name }} {{ $deliveryboy->last_name }}
    </td>
    <td>
        {{ $deliveryboy->email }}
    </td>
    <td>
        @if(!empty($deliveryboy->entry_street_address))
        {{ $deliveryboy->entry_street_address }},
        @endif
        @if(!empty($deliveryboy->entry_city))
        {{ $deliveryboy->entry_city }},
        @endif
        @if(!empty($deliveryboy->entry_state))
        {{ $deliveryboy->zone_name }},
        @endif
        @if(!empty($deliveryboy->entry_postcode))
        {{ $deliveryboy->entry_postcode }}
        @endif
        @if(!empty($deliveryboy->countries_name))
        {{ $deliveryboy->countries_name }}
        @endif
    </td>

    <td>
        <p>
            @if($deliveryboy->availability_status==8)
            <i class="fa fa-circle text-success"></i>
            @elseif($deliveryboy->availability_status==9)
            <i class="fa fa-circle text-success"></i>
            @elseif($deliveryboy->availability_status==10)
            <i class="fa fa-circle text-danger"></i>
            @elseif($deliveryboy->availability_status==11)
            <i class="fa fa-circle text-danger"></i>
            @else
            <i class="fa fa-circle text-primary"></i>
            @endif

            @foreach($data['statuses'] as $status)
            @if($deliveryboy->availability_status == $status->orders_status_id)
            {{ $status->orders_status_name }}
            @endif
            @endforeach


        </p>
    </td>

    <td>
        @if($deliveryboy->status==1)
        <span class="label label-success">
            {{ trans('labels.Active') }}
        </span>
        @elseif($deliveryboy->status==0)
        <span class="label label-danger">
            {{ trans('labels.InActive') }}
            @endif
    </td>

    <td>
        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}"
            href="{{url('admin/deliveryboys/edit') }}/{{$deliveryboy->id}}" class="btn btn-primary"
            style="width: 100%; margin-bottom: 5px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            {{ trans('labels.Edit') }}</a>
        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Rating') }}"
            href="{{url('admin/deliveryboys/ratings') }}/{{$deliveryboy->id}}" class="btn btn-success"
            style="width: 100%; margin-bottom: 5px;"><i class="fa fa-stars" aria-hidden="true"></i>
            {{ trans('labels.Rating') }}</a>
        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteCustomerFrom"
            users_id="{{ $deliveryboy->id }}" class="btn btn-danger" style="width: 100%; margin-bottom: 5px;"><i
                class="fa fa-trash" aria-hidden="true"></i> {{ trans('labels.Delete') }}</a>
    </td>
</tr>
@endif
@endforeach
@endif