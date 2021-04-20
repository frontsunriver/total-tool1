@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Delivery Boys') }} <small>{{ trans('labels.Listing Delivery Boys') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">{{ trans('labels.Delivery Boys') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 form-inline" id="contact-form">
                                    <form name='registration' id="registration" class="registration" method="get"
                                        action="{{url('admin/deliveryboys/filter')}}">
                                        <input type="hidden" value="{{csrf_token()}}">
                                        <div class="input-group-form search-panel ">
                                            <select type="button" class="btn btn-default dropdown-toggle form-control"
                                                data-toggle="dropdown" name="FilterBy" id="FilterBy">
                                                <option value="" selected disabled hidden>
                                                    {{ trans('labels.Filter By') }}</option>
                                                <option value="Name" @if(isset($filter)) @if ($filter=="Name" )
                                                    {{ 'selected' }} @endif @endif>{{ trans('labels.Name') }}</option>
                                                <option value="E-mail" @if(isset($filter)) @if ($filter=="E-mail" )
                                                    {{ 'selected' }}@endif @endif>{{ trans('labels.Email') }}</option>
                                                <option value="Phone" @if(isset($filter)) @if ($filter=="Phone" )
                                                    {{ 'selected' }}@endif @endif>{{ trans('labels.Phone') }}</option>
                                                <option value="Address" @if(isset($filter)) @if ($filter=="Address" )
                                                    {{ 'selected' }}@endif @endif>{{ trans('labels.Address') }}</option>
                                                <!-- <option value="Suburb" @if(isset($filter)) @if ($filter=="Suburb" ) {{ 'selected' }}@endif @endif>{{ trans('labels.Suburb') }}</option> -->
                                                <option value="Postcode" @if(isset($filter)) @if ($filter=="Postcode" )
                                                    {{ 'selected' }}@endif @endif>{{ trans('labels.Postcode') }}
                                                </option>
                                                <option value="City" @if(isset($filter)) @if ($filter=="City" )
                                                    {{ 'selected' }}@endif @endif>{{ trans('labels.City') }}</option>
                                                <option value="State" @if(isset($filter)) @if ($filter=="State" )
                                                    {{ 'selected' }}@endif @endif>{{ trans('labels.State') }}</option>
                                                <option value="Country" @if(isset($filter)) @if ($filter=="Country" )
                                                    {{ 'selected' }}@endif @endif>{{ trans('labels.Country') }}</option>
                                            </select>
                                            <input type="text" class="form-control input-group-form " name="parameter"
                                                placeholder="Search term..." id="parameter" @if(isset($parameter))
                                                value="{{$parameter}}" @endif>
                                            <button class="btn btn-primary " id="submit" type="submit"><span
                                                    class="glyphicon glyphicon-search"></span></button>
                                            @if(isset($parameter,$filter)) <a class="btn btn-danger "
                                                href="{{url('admin/deliveryboys/display')}}"><i class="fa fa-ban"
                                                    aria-hidden="true"></i> </a>@endif
                                        </div>
                                    </form>
                                    <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                </div>
                                <div class="box-tools pull-right">
                                    <a href="{{ url('admin/deliveryboys/add')}}" type="button"
                                        class="btn btn-block btn-primary">{{ trans('labels.Adddeliveryboy') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if (count($errors) > 0)
                                @if($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    {{$errors->first()}}
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>@sortablelink('id', trans('labels.ID') )</th>
                                            <th>{{ trans('labels.Name') }}</th>
                                            <th>{{ trans('labels.EmailAddress') }}</th>
                                            <th>{{ trans('labels.Flosting Cash') }}</th>
                                            <th>{{ trans('labels.Wallet') }}</th>
                                            <th>@sortablelink('entry_street_address', trans('labels.Address'))</th>
                                            <th>@sortablelink('status', trans('labels.Availability Status'))</th>
                                            <th>@sortablelink('status', trans('labels.Account Status'))</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customers-table">
                                        @if (isset($data['deliveryboys']))
                                        @foreach ($data['deliveryboys'] as $key=>$deliveryboy)
                                        <tr>
                                            <td>{{ $deliveryboy->id }}</td>
                                            <td>
                                                {{ $deliveryboy->first_name }} {{ $deliveryboy->last_name }}
                                            </td>
                                            <td style="text-transform: lowercase">
                                                {{ $deliveryboy->email }}
                                            </td>
                                            <td>{{ $deliveryboy->floating_cash }}</td>
                                            <td>{{ $deliveryboy->wallet_amount }}</td>
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
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                    title="{{ trans('labels.Edit') }}"
                                                    href="{{url('admin/deliveryboys/edit') }}/{{$deliveryboy->id}}"
                                                    class="btn btn-primary" style="width: 100%; margin-bottom: 5px;"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    {{ trans('labels.Edit') }}</a>
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                    title="{{ trans('labels.Finance') }}"
                                                    href="{{url('admin/deliveryboys/finance/sattlement/deliveryboy/') }}/{{$deliveryboy->id}}"
                                                    class="btn btn-success" style="width: 100%; margin-bottom: 5px;"><i
                                                        class="fa fa-stars" aria-hidden="true"></i>
                                                    {{ trans('labels.Finance') }}</a>
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                    title="{{ trans('labels.Rating') }}"
                                                    href="{{url('admin/deliveryboys/ratings') }}/{{$deliveryboy->id}}"
                                                    class="btn btn-success" style="width: 100%; margin-bottom: 5px;"><i
                                                        class="fa fa-stars" aria-hidden="true"></i>
                                                    {{ trans('labels.Rating') }}</a>
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                    title="{{ trans('labels.Delete') }}" id="deleteCustomerFrom"
                                                    users_id="{{ $deliveryboy->id }}" class="btn btn-danger"
                                                    style="width: 100%; margin-bottom: 5px;"><i class="fa fa-trash"
                                                        aria-hidden="true"></i> {{ trans('labels.Delete') }}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4">{{ trans('labels.NoRecordFound') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                @if (count($data['deliveryboys']) > 0)
                                <div class="col-xs-12 text-right">
                                    {!! $data['deliveryboys']->appends(\Request::except('page'))->render() !!}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

        <!-- /.row -->

        <!-- deleteCustomerModal -->
        <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteCustomerModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="deleteCustomerModalLabel">{{ trans('labels.Delete') }}</h4>
                    </div>
                    {!! Form::open(array('url' =>'admin/deliveryboys/delete', 'name'=>'deleteCustomer',
                    'id'=>'deleteCustomer', 'method'=>'post', 'class' => 'form-horizontal',
                    'enctype'=>'multipart/form-data')) !!}
                    {!! Form::hidden('action', 'delete', array('class'=>'form-control')) !!}
                    {!! Form::hidden('users_id', '', array('class'=>'form-control', 'id'=>'users_id')) !!}
                    <div class="modal-body">
                        <p>{{ trans('labels.DeleteRecordText') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('labels.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('labels.Delete') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog"
            aria-labelledby="notificationModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content notificationContent">

                </div>
            </div>
        </div>

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

@endsection