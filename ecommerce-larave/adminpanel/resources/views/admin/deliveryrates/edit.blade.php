@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.editshippingrate') }} <small>{{ trans('labels.editshippingrate') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/deliveryrates/display')}}"><i class="fa fa-dashboard"></i>{{ trans('labels.shippingrates') }}</a></li>
            <li class="active">{{ trans('labels.editshippingrate') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.editshippingrate') }}</h3>
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
                                <div class="box box-info"><br>

                                    @if(count($result['message'])>0)
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{ $result['message'] }}
                                    </div>
                                    @endif
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="box-body">

                                        {!! Form::open(array('url' =>'admin/deliveryrates/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        {!! Form::hidden('id',  $result['deliveryrates']->delievery_time_slot_with_zone_id, array('class'=>'form-control', 'id'=>'languages_id'))!!}

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Time Duration') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                <select name="time_duration" class="form-control">
                                                    <option value="06:00AM-08:00AM" @if($result['deliveryrates']->time_duration=='06:00AM-08:00AM') selected @endif > 6:00AM to 8:00AM</option>
                                                    <option value="08:00AM-10:00AM" @if($result['deliveryrates']->time_duration=='08:00AM-10:00AM') selected @endif> 8:00AM to 10:00AM</option>
                                                    <option value="10:00AM-12:00PM" @if($result['deliveryrates']->time_duration=='10:00AM-12:00PM') selected @endif> 10:00AM to 12:00PM</option>
                                                    <option value="12:00PM-02:00PM" @if($result['deliveryrates']->time_duration=='12:00PM-02:00PM') selected @endif> 12:00PM to 02:00PM</option>
                                                    <option value="02:00PM-04:00PM" @if($result['deliveryrates']->time_duration=='02:00PM-04:00PM') selected @endif> 02:00PM to 04:00PM</option>
                                                    <option value="04:00PM-06:00PM" @if($result['deliveryrates']->time_duration=='04:00PM-06:00PM') selected @endif> 04:00PM to 06:00PM</option>
                                                    <option value="06:00PM-08:00PM" @if($result['deliveryrates']->time_duration=='06:00PM-08:00PM') selected @endif> 06:00PM to 08:00PM</option>
                                                    <option value="08:00PM-11:00PM" @if($result['deliveryrates']->time_duration=='08:00PM-11:00PM') selected @endif> 08:00PM to 11:00PM</option>
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.ChooseTaxClass') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Zone') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                              <select name="zone_id" class="form-control">
                                                  @foreach($result['zones'] as $zones)
                                                  <option value="{{ $zones->zone_id }}" @if($result['deliveryrates']->zone_id == $zones->zone_id) selected @endif> {{ $zones->zone_name }}</option>
                                                  @endforeach
                                              </select>
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRateText') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Rate') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('delivery_price', $result['deliveryrates']->delivery_price, array('class'=>'form-control number-validate', 'id'=>'delivery_price'))!!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>
                                            </div>
                                        </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                            <a href="{{ URL::to('admin/deliveryrates/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                        </div>
                                        <!-- /.box-footer -->
                                        {!! Form::close() !!}
                                    </div>
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

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
