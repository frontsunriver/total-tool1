@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.UPSShippingSetting') }} <small>{{ trans('labels.Setting') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/shippingmethods/display')}}"><i class="fa fa-dashboard"></i>{{ trans('labels.ShippingMethods') }}</a></li>
                <li class="active">{{ trans('labels.UPSShippingSetting') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.UPSShippingSetting') }}</h3>
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
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="box-body">
                                            {!! Form::open(array('url' =>'admin/shippingmethods/updateupsshipping', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('table_name',  $result['ups_shipping']['ups_description'][0]->table_name , array('class'=>'form-control', 'id'=>'table_name')) !!}
                                            <div class="form-group">
                                                <label for="shippingEnvironment" class="col-sm-2 col-md-3 control-label" style="">{{ trans('labels.TestProductionMode') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <label class=" control-label">
                                                        <input type="radio" name="shippingEnvironment" value="0" class="flat-red" @if($result['ups_shipping']['ups_shipping']->shippingEnvironment==0) checked @endif > &nbsp;{{ trans('labels.Test') }}
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class=" control-label">
                                                        <input type="radio" name="shippingEnvironment" value="1" class="flat-red" @if($result['ups_shipping']['ups_shipping']->shippingEnvironment==1) checked @endif >  &nbsp; {{ trans('labels.Production') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ShippingServiceType') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="serviceType[]" class="form-control" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                                        <option @if(in_array('US_01', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="US_01">{{ trans('labels.NextDayAir') }} </option>
                                                        <option @if(in_array('US_02', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="US_02">{{ trans('labels.2ndDayAir') }} </option>
                                                        <option @if(in_array('US_03', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="US_03">{{ trans('labels.Ground') }}</option>
                                                    <!--<option @if(in_array('IN_07', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="IN_07">Worldwide Express </option>-->
                                                    <!--<option @if(in_array('IN_54', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="IN_54">Worldwide Express Plus</option>-->
                                                    <!--<option @if(in_array('IN_08', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="IN_08">Worldwide Expedited</option>-->
                                                    <!--<option @if(in_array('IN_11', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="IN_11">Standard</option>-->
                                                        <option @if(in_array('US_12', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="US_12">{{ trans('labels.3DaySelect') }} </option>
                                                        <option @if(in_array('US_13', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="US_13">{{ trans('labels.NextDayAirSaver') }} </option>
                                                        <option @if(in_array('US_14', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="US_14">{{ trans('labels.NextDayAirEarlyAM') }}</option>
                                                        <option @if(in_array('US_59', explode(',', $result['ups_shipping']['ups_shipping']->serviceType))) selected @endif value="US_59">{{ trans('labels.2ndDayAirAM') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ShippingServiceTypeText') }}</span>

                                                </div>
                                            </div>
                                        <!--<div class="form-group">
								{{--<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Title') }}</label>--}}
								<div class="col-sm-10 col-md-4">
									{{--{!! Form::text('title', $result['ups_shipping']['ups_shipping']->title, array('class'=>'form-control', 'id'=>'title'))!!}--}}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
{{--{{ trans('labels.ShippingTitleText') }}</span>--}}
								</div>
							</div>-->
                                            @foreach($result['description'] as $description_data)
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="name_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['name']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ShippingmethodName') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{trans('labels.NextDayAir') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="nextDayAir_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['nextDayAir']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{trans('labels.NextDayAir') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{trans('labels.2ndDayAir') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="secondDayAir_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['secondDayAir']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{trans('labels.2ndDayAir') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{trans('labels.Ground') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="ground_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['ground']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{trans('labels.Ground') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{trans('labels.3DaySelect') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="threeDaySelect_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['threeDaySelect']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{trans('labels.3DaySelect') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{trans('labels.NextDayAirSaver') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="nextDayAirSaver_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['nextDayAirSaver']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{trans('labels.NextDayAirSaver') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{trans('labels.NextDayAirEarlyAM') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="nextDayAirEarlyAM_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['nextDayAirEarlyAM']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{trans('labels.NextDayAirEarlyAM') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{trans('labels.2ndDayAirAM') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="secondndDayAirAM_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['secondndDayAirAM']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{trans('labels.2ndDayAirAM') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>


                                            @endforeach
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.AccessKey') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('access_key',  $result['ups_shipping']['ups_shipping']->access_key, array('class'=>'form-control', 'id'=>'access_key'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.AccessKeyText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.UserName') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('user_name',  $result['ups_shipping']['ups_shipping']->user_name, array('class'=>'form-control', 'id'=>'user_name'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ShippingUserNameText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Password') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('password',  $result['ups_shipping']['ups_shipping']->password, array('class'=>'form-control', 'id'=>'password'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.UPSSshippingPassword') }}.</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="shippingEnvironment" class="col-sm-2 col-md-3 control-label" style="">{{ trans('labels.PickupMethod') }} :</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <label class=" control-label">
                                                        <input type="radio" name="pickup_method" value="01" class="flat-red" @if($result['ups_shipping']['ups_shipping']->pickup_method==01) checked @endif > &nbsp;{{ trans('labels.DailyPickup') }}
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <label class=" control-label">
                                                        <input type="radio" name="pickup_method" value="03" class="flat-red" @if($result['ups_shipping']['ups_shipping']->pickup_method==03) checked @endif >  &nbsp;
                                                        {{ trans('labels.CustomerCounter') }}
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <label class=" control-label">
                                                        <input type="radio" name="pickup_method" value="06" class="flat-red" @if($result['ups_shipping']['ups_shipping']->pickup_method==06) checked @endif >  &nbsp;{{ trans('labels.OneTimePickup') }}
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <label class=" control-label">
                                                        <input type="radio" name="pickup_method" value="07" class="flat-red" @if($result['ups_shipping']['ups_shipping']->pickup_method==07) checked @endif >  &nbsp;{{ trans('labels.OnCallAirPickup') }}
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <label class=" control-label">
                                                        <input type="radio" name="pickup_method" value="19" class="flat-red" @if($result['ups_shipping']['ups_shipping']->pickup_method==19) checked @endif >  &nbsp; {{ trans('labels.LetterCenter') }}
                                                    </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <label class=" control-label">
                                                        <input type="radio" name="pickup_method" value="20" class="flat-red" @if($result['ups_shipping']['ups_shipping']->pickup_method==20) checked @endif >  &nbsp;
                                                        {{ trans('labels.AirServiceCenter') }}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Address') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('address_line_1',  $result['ups_shipping']['ups_shipping']->address_line_1, array('class'=>'form-control', 'id'=>'address_line_1'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><strong>
                                                        {{ trans('labels.AddressShippingText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.State') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('state',  $result['ups_shipping']['ups_shipping']->state, array('class'=>'form-control', 'id'=>'state'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.StateShippingText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Postcode') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('post_code',  $result['ups_shipping']['ups_shipping']->post_code, array('class'=>'form-control', 'id'=>'post_code'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.CityShippingText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.City') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('city',  $result['ups_shipping']['ups_shipping']->city, array('class'=>'form-control', 'id'=>'city'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.CityShippingText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Country') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="country" class="form-control select2">
                                                        @foreach($result['countries'] as $countries)
                                                            <option
                                                                    @if($result['ups_shipping']['ups_shipping']->country == $countries->countries_iso_code_2)
                                                                    selected
                                                                    @endif
                                                                    value="{{ $countries->countries_iso_code_2 }}"> {{ $countries->countries_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.CountryShippingText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="status" class="form-control select2">
                                                        <option @if($result['shipping_methods'][0]->status == 1) selected @endif value="1" > {{ trans('labels.Active') }} </option>
                                                        <option @if($result['shipping_methods'][0]->status == 0) selected @endif value="0"> {{ trans('labels.InActive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ShippingStatus') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                                <a href="{{ URL::to('admin/shippingmethods/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
