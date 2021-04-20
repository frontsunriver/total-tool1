@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Setting') }}<small>{{ trans('labels.Setting') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">{{ trans('labels.Setting') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.Setting') }}</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!--<div class="box-header with-border">
                                          <h3 class="box-title">Setting</h3>
                                        </div>-->
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="box-body">
                                        @if( count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-success" role="alert">
                                            <span class="icon fa fa-check" aria-hidden="true"></span>
                                            <span class="sr-only">{{ trans('labels.Setting') }}:</span>
                                            {{ $error }}</div>
                                        @endforeach
                                        @endif

                                        {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                        <h4>{{ trans('labels.generalSetting') }}</h4>
                                        <hr>
                                        <div class="form-group">
                                       		<label class="col-sm-2 col-md-3 control-label" style="">{{ trans('labels.Web/App Environment') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <label class=" control-label">
                                                      <input type="radio" name="environmentt" value="Maintenance" class="flat-red" @if($result['commonContent']['setting']['environmentt'] == 'Maintenance') checked @endif > &nbsp;{{ trans('labels.Maintenance') }}
                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                <label class=" control-label">
                                                      <input type="radio" name="environmentt" value="production" class="flat-red" @if($result['commonContent']['setting']['environmentt'] == 'production') checked @endif >  &nbsp;{{ trans('labels.production') }}
                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                <label class=" control-label">
                                                      <input type="radio" name="environmentt" value="local" class="flat-red" @if($result['commonContent']['setting']['environmentt'] == 'local') checked @endif >  &nbsp;{{ trans('labels.local') }}
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                       		<label class="col-sm-2 col-md-3 control-label" style="">{{ trans('labels.Inventory') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <label class=" control-label">
                                                      <input type="radio" name="Inventory" value="1" class="flat-red" @if($result['commonContent']['setting']['Inventory'] == '1') checked @endif > &nbsp;{{ trans('labels.Enabled') }}
                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                <label class=" control-label">
                                                      <input type="radio" name="Inventory" value="0" class="flat-red" @if($result['commonContent']['setting']['Inventory'] == '0') checked @endif >  &nbsp;{{ trans('labels.Disabled') }}
                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>

                                       
                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Maintenance Text') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('maintenance_text',  stripslashes($result['commonContent']['setting']['maintenance_text']), array('class'=>'form-control', 'id'=>'maintenance_text')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Maintenance Text detail') }}</span>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.website Link') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('external_website_link', $result['commonContent']['setting']['external_website_link'], array('class'=>'form-control', 'id'=>'external_website_link')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Website Link Text') }}</span>
                                            </div>
                                        </div>
                                       
                                        @if($result['commonContent']['setting']['facebook_callback_url'] ==1 )
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Android App Link') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('android_app_link',$result['commonContent']['setting']['android_app_link'], array('class'=>'form-control', 'id'=>'android_app_link')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Android App Link') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Iphone App Link') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('iphone_app_link',$result['commonContent']['setting']['iphone_app_link'], array('class'=>'form-control', 'id'=>'iphone_app_link')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Iphone App Link') }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.AppName') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('app_name', $result['commonContent']['setting']['app_name'], array('class'=>'form-control', 'id'=>'app_name')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.AppNameText') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.NewProductDuration') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('new_product_duration', $result['commonContent']['setting']['new_product_duration'], array('class'=>'form-control', 'id'=>'new_product_duration')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.NewProductDurationText') }}</span>
                                            </div>
                                        </div>

                                        

                                        <hr>
                                        <h4>{{ trans('labels.InqueryEmails') }}</h4>
                                        <hr>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ContactUsEmail') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('contact_us_email', $result['commonContent']['setting']['contact_us_email'], array('class'=>'form-control', 'id'=>'contact_us_email')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    {{ trans('labels.ContactUsEmailText') }}</span>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4>{{ trans('labels.OrderEmail') }}</h4>
                                        <hr>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.OrderEmail') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('order_email', $result['commonContent']['setting']['order_email'], array('class'=>'form-control', 'id'=>'order_email')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    {{ trans('labels.OrderEmailText') }}</span>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4>{{ trans('labels.Orders') }}</h4>
                                        <hr>
                                        

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Min Order Price') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('min_order_price',$result['commonContent']['setting']['min_order_price'], array('class'=>'form-control', 'id'=>'min_order_price')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    {{ trans('labels.Min Order Price Text') }}</span>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4>{{ trans('labels.OurInfo') }}</h4>
                                        <hr>
                                       
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.PhoneNumber') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('phone_no', $result['commonContent']['setting']['phone_no'], array('class'=>'form-control', 'id'=>'phone_no')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                                    {{ trans('labels.PhoneNumberText') }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Address') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('address', $result['commonContent']['setting']['address'], array('class'=>'form-control', 'id'=>'address')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.AddressText') }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.City') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('city', $result['commonContent']['setting']['city'], array('class'=>'form-control', 'id'=>'city')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.CityText') }}</span>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.State') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('state', $result['commonContent']['setting']['state'], array('class'=>'form-control', 'id'=>'state')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.StateText') }}</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Zip') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('zip', $result['commonContent']['setting']['zip'], array('class'=>'form-control', 'id'=>'zip')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.ZipText') }}</span>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Country') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('country', $result['commonContent']['setting']['country'], array('class'=>'form-control', 'id'=>'country')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.CountryContactUs') }}</span>
                                            </div>
                                        </div>
                                       


                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Latitude') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('latitude', $result['commonContent']['setting']['latitude'], array('class'=>'form-control', 'id'=>'latitude')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.latitudeText') }}</span>
                                            </div>
                                        </div>
                                       
                                       
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Longitude') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('longitude', $result['commonContent']['setting']['longitude'], array('class'=>'form-control', 'id'=>'longitude')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.LongitudeText') }}</span>
                                            </div>
                                        </div>

                                    </div>



                                    <!-- /.box-body -->
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                        <a href="{{ URL::to('admin/dashboard/this_month')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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

        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
