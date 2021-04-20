@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.SendNotification') }} <small>{{ trans('labels.SendNotification') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/devices/display')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.ListingDevices') }}</a></li>
            <li class="active">{{ trans('labels.SendNotification') }}</li>
        </ol>
    </section>
 
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        @if(!empty($result['devices'][0]->customers_picture))
                        <img class="profile-user-img img-responsive img-circle"
                            src="{{asset('').$result['devices'][0]->customers_picture}}"
                            alt="{{ $result['devices'][0]->customers_firstname }} profile picture">
                        <h3 class="profile-username text-center">{{ $result['devices'][0]->customers_firstname }}
                            {{ $result['devices'][0]->customers_lastname }}</h3>
                        @endif

                        <ul class="list-group list-group-unbDeviceed">
                            <li class="list-group-item">
                                <b>{{ trans('labels.DeviceType') }}</b> <a class="pull-right">
                                    @if($result['devices'][0]->device_type == '1')
                                    {{ trans('labels.IOS') }}
                                    @elseif($result['devices'][0]->device_type == '2')
                                    {{ trans('labels.Android') }}
                                    @elseif($result['devices'][0]->device_type == '3')
                                    {{ trans('labels.Other') }}
                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>{{ trans('labels.DeviceOS') }} </b> <a
                                    class="pull-right">{{ $result['devices'][0]->device_os }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>{{ trans('labels.Manufacturer') }}</b> <a
                                    class="pull-right">{{$result['devices'][0]->manufacturer }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>{{ trans('labels.DeviceModel') }}</b> <a
                                    class="pull-right">{{ $result['devices'][0]->device_model }}</a>
                            </li>
                            <li class="list-group-item">
                                
                                <b>{{ trans('labels.RegisterDate') }}</b> <a
                                    class="pull-right">{{ date('d/m/Y', strtotime($result['devices'][0]->created_at)) }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>{{ trans('labels.Status') }}</b> <a class="pull-right">
                                    @if($result['devices'][0]->status=='0')
                                    <span class="badge bg-red"> {{ trans('labels.Inactive') }}</span>
                                    @elseif($result['devices'][0]->status=='1')
                                    <span class="badge bg-light-blue"> {{ trans('labels.Active') }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->

                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#push-notification"
                                data-toggle="tab">{{ trans('labels.SendNotification') }}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="push-notification">
                            {!! Form::open(array('url' =>'admin/devices/viewdevices', 'id'=>'sendNotificaionForm',
                            'method'=>'post', 'class' => 'form-horizontal form-validate',
                            'enctype'=>'multipart/form-data')) !!}

                            {!! Form::hidden('device_type', $result['devices'][0]->device_type,
                            array('class'=>'form-control', 'id'=>'device_type')) !!}
                            {!! Form::hidden('device_id', $result['devices'][0]->device_id,
                            array('class'=>'form-control', 'id'=>'device_id')) !!}

                            <div class="alert alert-success alert-dismissible callout hide sent-push">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                {{ trans('labels.NotifcationSentMessage') }}
                            </div>
                            <div class="alert alert-danger alert-dismissible callout not-sent hide">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                {{ trans('labels.NotifcationSentErrorMessage') }}
                            </div>

                            <div class="form-group">
                                <label for="inputName"
                                    class="col-sm-2 control-label">{{ trans('labels.Title') }}</label>

                                <div class="col-sm-10">
                                    {!! Form::text('title', '', array('class'=>'form-control field-validate',
                                    'required', 'id'=>'title')) !!}
                                    <span class="help-block"
                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                        {{ trans('labels.EnterNotificationTitle') }}</span>
                                    <span
                                        class="help-block hidden title-error">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name"
                                    class="col-sm-2 col-md-2 control-label">{{ trans('labels.Image') }}</label>
                                <div class="col-sm-10 col-md-4">
                                    <!-- Modal -->
                                    <div class="modal fade embed-images" id="ModalmanufacturedICone" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        id="closemodal" aria-label="Close"><span
                                                            aria-hidden="true">×</span></button>
                                                    <h3 class="modal-title text-primary" id="myModalLabel">
                                                        {{ trans('labels.Choose Image') }} </h3>
                                                </div>
                                                <div class="modal-body manufacturer-image-embed">
                                                    @if(isset($allimage))
                                                    <select class="image-picker show-html " name="image_id"
                                                        id="select_img">
                                                        <option value=""></option>
                                                        @foreach($allimage as $key=>$image)
                                                        <option data-img-src="{{asset($image->path)}}"
                                                            class="imagedetail" data-img-alt="{{$key}}"
                                                            value="{{$image->id}}"> {{$image->id}} </option>
                                                        @endforeach
                                                    </select>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{url('admin/media/add')}}" target="_blank"
                                                        class="btn btn-primary pull-left">{{ trans('labels.Add Image') }}</a>
                                                    <button type="button" class="btn btn-default refresh-image"><i
                                                            class="fa fa-refresh"></i></button>
                                                    <button type="button" class="btn btn-success" id="selectedICONE"
                                                        data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="imageselected">
                                        {!! Form::button(trans('labels.Add Image'), array('id'=>'newIcon','class'=>"btn
                                        btn-primary field-validate", 'data-toggle'=>"modal",
                                        'data-target'=>"#ModalmanufacturedICone" )) !!}
                                        <br>
                                        <div id="selectedthumbnailIcon" class="selectedthumbnail col-md-5"> </div>
                                        <div class="closimage">
                                            <button type="button" class="close pull-left image-close " id="image-Icone"
                                                style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; "
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="help-block"
                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ImageText') }}</span>
                                    <br>
                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="inputExperience"
                                    class="col-sm-2 control-label">{{ trans('labels.Message') }}</label>
                                <div class="col-sm-10">
                                    {!! Form::textarea('message', '', array('class'=>'form-control', 'required',
                                    'rows'=>'5', 'id'=>'message')) !!}
                                    <span class="help-block"
                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.MessageText') }}</span>
                                    <span
                                        class="help-block hidden message-error">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary"
                                        id="send-notificaion">{{ trans('labels.SendNotification') }}</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
@endsection