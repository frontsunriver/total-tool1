@if (isset($vendors['vendors']))
@foreach ($vendors['vendors'] as $key=>$vendor)
@if($vendor->is_seen == 0)
<tr>
    <td>{{ $vendor->id }}</td>
    <td>
        {{ $vendor->first_name }} {{ $vendor->last_name }}
    </td>
    <td>
        {{ $vendor->email }}
    </td>
    <td>
        @if(!empty($vendor->entry_street_address))
        {{ $vendor->entry_street_address }},
        @endif
        @if(!empty($vendor->entry_city))
        {{ $vendor->entry_city }},
        @endif
        @if(!empty($vendor->entry_state))
        {{ $vendor->zone_name }},
        @endif
        @if(!empty($vendor->entry_postcode))
        {{ $vendor->entry_postcode }}
        @endif
        @if(!empty($vendor->countries_name))
        {{ $vendor->countries_name }}
        @endif
    </td>
    <td>
        @if($vendor->status==1)
        <span class="label label-success">
        {{ trans('labels.Active') }}
        </span>
        @elseif($vendor->status==0)
        <span class="label label-danger">
            {{ trans('labels.InActive') }}
        @endif
    </td>
    <td>
        @if($vendor->shop_status==1)
        <span class="label label-success">
        {{ trans('labels.Open') }}
        </span>
        @elseif($vendor->shop_status==0)
        <span class="label label-danger">
            {{ trans('labels.Close') }}
        @endif
    </td>
    <td>
        <ul class="nav table-nav">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    {{ trans('labels.Action') }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a role="menuitem" tabindex="-1"
                            href="{{url('admin/vendors/edit') }}/{{$vendor->id}}">{{ trans('labels.EditVendor') }}</a>
                    </li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation"><a data-toggle="tooltip" data-placement="bottom"
                            title="{{ trans('labels.Delete') }}" id="deleteCustomerFrom"
                            users_id="{{ $vendor->id }}">{{ trans('labels.Delete') }}</a></li>
                </ul>
            </li>
        </ul>
    </td>
</tr>
@endif
@endforeach
@endif