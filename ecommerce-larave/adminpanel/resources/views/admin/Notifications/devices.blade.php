@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.Devices') }} <small>{{ trans('labels.ListingDevices') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.Devices') }}</li>
            </ol>
        </section>

        <!--  content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->
 
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.ListingDevices') }} </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="pull-right col-xs-12 col-sm-4">
                                        {!! Form::open(array( 'method'=>'get', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                        <div class="form-group">
                                            <label for="name" class="control-label col-sm-3">{{ trans('labels.Filter') }} </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="filter" onChange="this.form.submit()">                                                
                                                    @if($web_setting[66]->value=='1' and $web_setting[67]->value=='1' or $web_setting[66]->value=='1' and $web_setting[67]->value=='0')
                                                        <option value="">{{ trans('labels.All') }}</option>
                                                    @endif
                                                    @if($web_setting[66]->value=='1')
                                                        <option value="1" @if(isset($_REQUEST['filter']) and $_REQUEST['filter']=='1') selected @endif>{{ trans('labels.IOS') }} </option>
                                                        <option value="2" @if(isset($_REQUEST['filter']) and $_REQUEST['filter']=='2') selected @endif>{{ trans('labels.Android') }}</option>
                                                    @endif
                                                    @if($web_setting[67]->value=='1')
                                                        <option value="3" @if(isset($_REQUEST['filter']) and $_REQUEST['filter']=='3') selected @endif>{{ trans('labels.Website') }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('labels.ID') }}</th>
                                            <th>{{ trans('labels.DeviceDetail') }}</th>
                                            <th>{{ trans('labels.DeviceOS') }}</th>
                                            <th>{{ trans('labels.UserInfo') }}</th>
                                            <th>{{ trans('labels.Status') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['devices'])>0)
                                            @foreach ($result['devices'] as $key=>$device)
                                                <tr>
                                                    <td>{{ $device->id }}</td>
                                                    <td>
                                                        <strong>Device Type: </strong>
                                                        @if($device->device_type == '1')
                                                            {{ trans('labels.IOS') }}
                                                        @elseif($device->device_type == '2')
                                                            {{ trans('labels.Android') }}
                                                        @elseif($device->device_type == '3')
                                                            {{ trans('labels.Website') }}
                                                        @endif
                                                        <br>
                                                        <strong>{{ trans('labels.Manufacturer') }}: </strong>{{ $device->manufacturer }}
                                                        <br>

                                                        <strong>{{ trans('labels.DeviceModel') }}: </strong>{{ $device->device_model }}
                                                        <br>
                                                        <strong>{{ trans('labels.RegisterDate') }}: </strong>{{ date('d/m/Y', strtotime($device->created_at)) }}

                                                    </td>

                                                    <td>{{ $device->device_os }}</td>

                                                    <td>{{ $device->first_name }} {{ $device->last_name }}</td>

                                                    <td>
                                                        @if($device->status==0)
                                                            <span class="label label-warning">
                                                                {{ trans('labels.InActive') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/devices/display")}}?id={{ $device->id}}&active=no" class="method-status">
                                                                {{ trans('labels.InActive') }}
                                                            </a>
                                                        @endif
                                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                                        @if($device->status==1)
                                                            <span class="label label-success">
                                                                {{ trans('labels.Active') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/devices/display")}}?id={{ $device->id}}&active=yes" class="method-status">
                                                                {{ trans('labels.Active') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.SendNotification') }}" href="{{url('admin/devices/viewdevices')}}/{{ $device->id }}" class="badge bg-light-blue btn btn-primary">{{ trans('labels.Send') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['devices']->links()}}
                                    </div>
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
            <!-- deletedeviceModal -->
            <div class="modal fade" id="deletedeviceModal" tabindex="-1" role="dialog" aria-labelledby="deletedeviceModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deletedeviceModalLabel">{{ trans('labels.DeleteDevice') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/devices/deletedevice', 'name'=>'deletedevice', 'id'=>'deletedevice', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'devices_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteDeviceText') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}Close</button>
                            <button type="submit" class="btn btn-primary" id="deletedevice">{{ trans('labels.Delete') }}Delete</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!--  row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
