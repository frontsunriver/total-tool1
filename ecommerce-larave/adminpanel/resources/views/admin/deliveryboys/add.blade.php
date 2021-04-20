@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Adddeliveryboy') }} <small>{{ trans('labels.Adddeliveryboy') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/deliveryboys/display')}}"><i class="fa fa-users"></i> {{ trans('labels.Listing Delivery Boys') }}</a></li>
            <li class="active">{{ trans('labels.Adddeliveryboy') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.Adddeliveryboy') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">

                                    @if(session()->has('message'))
                                        <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong> {{ session()->get('message') }} </strong>
                                        </div>
                                    @endif

                                    @if (count($errors) > 0)
                                      @if($errors->any())
                                      <div class="alert alert-danger alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          {{$errors->first()}}
                                      </div>
                                      @endif
                                    @endif

                                    <div class="box-body">
                                        {!! Form::open(array('url' =>'admin/deliveryboys/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                          <h4>{{ trans('labels.Delivery Boy Info') }}</h4>
                                        <hr>
                                        <div class="row">
                                          <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FirstName') }} </label>
                                              <div class="col-sm-10 col-md-8">
                                                {!! Form::text('first_name',  '', array('class'=>'form-control field-validate', 'id'=>'first_name')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.FirstNameText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.LastName') }} </label>
                                              <div class="col-sm-10 col-md-8">
                                                {!! Form::text('last_name',  '', array('class'=>'form-control field-validate', 'id'=>'last_name')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.lastNameText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-xs-12 col-sm-6">
                                            <div class="form-group" id="imageIcone">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Avatar') }}</label>
                                                  <div class="col-sm-10 col-md-8">
                                                      <!-- Modal -->
                                                      <div class="modal fade embed-images" id="ModalmanufacturedICone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                          <div class="modal-dialog" role="document">
                                                              <div class="modal-content">
                                                                  <div class="modal-header">
                                                                      <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                      <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                                  </div>
                                                                  <div class="modal-body manufacturer-image-embed">
                                                                      @if(isset($allimage))
                                                                      <select class="image-picker show-html field-validate" name="image_id" id="select_img">
                                                                          <option value=""></option>
                                                                          @foreach($allimage as $key=>$image)
                                                                            <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                          @endforeach
                                                                      </select>
                                                                      @endif
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                      <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Image') }}</a>
                                                                      <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                                      <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div id="imageselected">
                                                        {!! Form::button(trans('labels.Add Image'), array('id'=>'newIcon','class'=>"btn btn-primary", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone" )) !!}
                                                        <br>
                                                        <div id="selectedthumbnailIcon" class="selectedthumbnail col-md-5"> </div>
                                                        <div class="closimage">
                                                            <button type="button" class="close pull-left image-close " id="image-Icone"
                                                              style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                      </div>
                                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ImageText') }}</span>
                                                      <br>
                                                  </div>
                                              </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6">
                                              <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Phone') }}</label>
                                                <div class="col-sm-10 col-md-8">
                                                  <div class="input-group col-xs-12">
                                                    <!-- <select name="country_code" class="form-control">
                                                        <option value="+91" >+91</option>
                                                    </select>
                                                    <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span> -->
                                                    {!! Form::text('phone',  '', array('class'=>'form-control phone-validate', 'id'=>'phone')) !!}
                                                  </div>
                                                 <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                 {{ trans('labels.TelephoneText') }}</span>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                              <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.DOB') }} </label>
                                                <div class="col-sm-10 col-md-8">
                                                  {!! Form::text('dob',  '', array('class'=>'form-control datepicker' , 'id'=>'dob', 'readonly'=>'readonly')) !!}
                                                 <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                 {{ trans('labels.DOBText') }}</span>
                                                </div>
                                              </div>
                                            </div>


                                            <div class="col-xs-12 col-sm-6">
                                              <div class="form-group">
                                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.blood_group') }} </label>
                                              <div class="col-sm-10 col-md-8">
                                                  <select name="blood_group" class="form-control">
                                                    <OPTION VALUE="A +ve">{{ trans('labels.A +ve') }} </OPTION>
                                                    <OPTION VALUE="A -ve">{{ trans('labels.A -ve') }} </OPTION>
                                                    <OPTION VALUE="B +ve">{{ trans('labels.B +ve') }}  </OPTION>
                                                    <OPTION VALUE="B -ve">{{ trans('labels.B -ve') }} </OPTION>
                                                    <OPTION VALUE="O +ve">{{ trans('labels.O +ve') }}</OPTION>
                                                    <OPTION VALUE="O -ve">{{ trans('labels.O -ve') }} </OPTION>
                                                    <OPTION VALUE="AB +ve">{{ trans('labels.AB +ve') }} </OPTION>
                                                    <OPTION VALUE="AB -ve">{{ trans('labels.AB -ve') }}AB -ve </OPTION>
                                                  </select>
                                                 <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                 {{ trans('labels.blood_groupText') }}</span>
                                              </div>
                                            </div>
                                          </div>



                                          </div>

                                          <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                              <div class="form-group">
                                              <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Commission') }} </label>
                                              <div class="col-sm-10 col-md-8">
                                                {!! Form::text('commission',  '0', array('class'=>'form-control field-validate' , 'id'=>'commission')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                {{ trans('labels.CommissionText') }}</span>
                                                
                                              </div>
                                            </div>
                                          </div>
                                          </div>

                                            <hr>
                                            <h4>{{ trans('labels.Login Info') }}</h4>
                                            <hr>
                                            <div class="row">
                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.EmailAddress') }} </label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('email',  '', array('class'=>'form-control email-validate', 'id'=>'email')) !!}
                                                     <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                     {{ trans('labels.EmailText') }}</span>
                                                    <span class="help-block hidden"> {{ trans('labels.EmailError') }}</span>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.PinCode') }}</label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('password', '', array('class'=>'form-control field-validate', 'id'=>'password')) !!}
                                	                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.PasswordText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                                  <div class="col-sm-10 col-md-8">
                                                    <select class="form-control" name="status">
                                                          <option value="1">{{ trans('labels.Active') }}</option>
                                                          <option value="0">{{ trans('labels.Inactive') }}</option>
                                	                  </select>
                                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                  {{ trans('labels.StatusText') }}</span>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Availability Status') }} </label>
                                                  <div class="col-sm-10 col-md-8">
                                                    <select class="form-control" name="availability_status">
                                                        @foreach($data['statuses'] as $status)
                                                          <option value="{{$status->orders_status_id}}">{{$status->orders_status_name}}</option>
                                                        @endforeach
                                	                  </select>
                                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                  {{ trans('labels.StatusText') }}</span>
                                                  </div>
                                                </div>
                                              </div>

                                            </div>


                                            <hr>
                                            <h4>{{ trans('labels.Address Info') }}</h4>
                                            <hr>

                                            <div class="row">

                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Address') }} </label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('address', '', array('class'=>'form-control field-validate', 'id'=>'address'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.AddressText') }}</span>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.City') }} </label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('city', '', array('class'=>'form-control field-validate', 'id'=>'City'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.CityText') }}</span>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>



                                          <div class="row">

                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ZipCode') }} </label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('zip', '', array('class'=>'form-control field-validate', 'id'=>'zip'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.ZipCode') }}</span>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Country') }} </label>
                                                  <div class="col-sm-10 col-md-8">
                                                    <select class="form-control field-validate" name="country_id" id="entry_country_id">
                                                    	<option value="">{{ trans('labels.SelectCountry') }}</option>
                                                    	@foreach($data['countries'] as $countries)
                                                    		<option value="{{ $countries->countries_id }}">{{ $countries->countries_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.CountryText') }}</span>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                  <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.State') }} </label>
                                                    <div class="col-sm-10 col-md-8">
                                                      <select class="form-control zoneContent field-validate" name="state_id">
                                                       	<option value="">{{ trans('labels.SelectZone') }}</option>
                                                       </select>
                                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.SelectZoneText') }}</span>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <h4>{{ trans('labels.Vehicle Info') }}</h4>
                                            <hr>

                                            <div class="row">
                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Vehicle_name') }}</label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bike_name', '', array('class'=>'form-control field-validate', 'id'=>'bike_name')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.Vehicle_nameText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.owner_name') }}</label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('owner_name', '', array('class'=>'form-control field-validate', 'id'=>'owner_name')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.owner_nameText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="row">
                                              <div class="col-xs-12 col-sm-6">

                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Vehicle_color') }}</label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bike_color', '', array('class'=>'form-control field-validate', 'id'=>'bike_color')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.Vehicle_colorText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                  </div>
                                                </div>

                                              </div>

                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.vehicle_registration_number') }}</label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('vehicle_registration_number', '', array('class'=>'form-control field-validate', 'id'=>'vehicle_registration_number')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.vehicle_registration_number') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="row">
                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Vehicle_details') }}</label>
                                                  <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bike_details', '', array('class'=>'form-control field-validate', 'id'=>'bike_details')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.Vehicle_detailsText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-xs-12 col-sm-6">

                                                <div class="form-group image-content" id='image-content-3'>
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.driving_license_image') }} </label>
                                                  <div class="col-sm-10 col-md-8" >
                                                      <!-- Modal -->
                                                      <div class="modal fade embed-images" id="imagemodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                          <div class="modal-dialog" role="document">
                                                              <div class="modal-content">
                                                                  <div class="modal-header">
                                                                      <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                      <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                                  </div>
                                                                  <div class="modal-body manufacturer-image-embed">
                                                                      @if(isset($allimage))
                                                                      <select class="image-picker show-html field-validate" name="driving_license_image">
                                                                          <option value=""></option>
                                                                          @foreach($allimage as $key=>$image)
                                                                            <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                          @endforeach
                                                                      </select>
                                                                      @endif
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                      <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Image') }}</a>
                                                                      <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                                      <button type="button" class="btn btn-success selected-image" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div id="imageselected">
                                                        {!! Form::button(trans('labels.Add Image'), array('class'=>"btn btn-primary add-image" )) !!}
                                                        <br>
                                                        <div class="selectedthumbnail col-md-5"> </div>
                                                        <div class="closimage">
                                                            <button type="button" class="close pull-left image-close show-image-btn"
                                                              style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                      </div>
                                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.driving_license_image') }}</span>
                                                      <br>
                                                  </div>
                                                </div>

                                              </div>
                                            </div>

                                            <div class="row">
                                              <div class="col-xs-12 col-sm-6">
                                                <div class="form-group image-content" id='image-content-1'>
                                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.vehicle_rc_book_image') }} </label>
                                                  <div class="col-sm-10 col-md-8" >
                                                      <!-- Modal -->
                                                      <div class="modal fade embed-images" id="imagemodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                          <div class="modal-dialog" role="document">
                                                              <div class="modal-content">
                                                                  <div class="modal-header">
                                                                      <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                      <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                                  </div>
                                                                  <div class="modal-body manufacturer-image-embed">
                                                                      @if(isset($allimage))
                                                                      <select class="image-picker show-html field-validate" name="vehicle_rc_book_image">
                                                                          <option value=""></option>
                                                                          @foreach($allimage as $key=>$image)
                                                                            <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                          @endforeach
                                                                      </select>
                                                                      @endif
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                      <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Image') }}</a>
                                                                      <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                                      <button type="button" class="btn btn-success selected-image" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div id="imageselected">
                                                        {!! Form::button(trans('labels.Add Image'), array('class'=>"btn btn-primary add-image" )) !!}
                                                        <br>
                                                        <div class="selectedthumbnail col-md-5"> </div>
                                                        <div class="closimage">
                                                            <button type="button" class="close pull-left image-close show-image-btn"
                                                              style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                      </div>
                                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ImageText') }}</span>
                                                      <br>
                                                  </div>
                                                </div>
                                              </div>


                                              
                                            </div>

                                            <hr>
                                    <h4>{{ trans('labels.Bank Info') }}</h4>
                                    <hr>
                                    <div class="row">

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="col-sm-2 col-md-3 control-label">{{ trans('labels.Account Title') }}
                                                </label>
                                                <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bank_name', '', array('class'=>'form-control
                                                    field-validate', 'id'=>'bank_name'))!!}
                                                    <span class="help-block"
                                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.Account Title Text') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="col-sm-2 col-md-3 control-label">{{ trans('labels.Account Number') }}
                                                </label>
                                                <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bank_account_number', '',
                                                    array('class'=>'form-control field-validate',
                                                    'id'=>'bank_account_number'))!!}
                                                    <span class="help-block"
                                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.Account Number Text') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="col-sm-2 col-md-3 control-label">{{ trans('labels.Routing Number') }}
                                                </label>
                                                <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bank_routing_number', '',
                                                    array('class'=>'form-control field-validate',
                                                    'id'=>'bank_routing_number'))!!}
                                                    <span class="help-block"
                                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.Routing Number Text') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="col-sm-2 col-md-3 control-label">{{ trans('labels.Bank Address') }}
                                                </label>
                                                <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bank_address', '',
                                                    array('class'=>'form-control field-validate',
                                                    'id'=>'bank_address'))!!}
                                                    <span class="help-block"
                                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.Bank Address Text') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="col-sm-2 col-md-3 control-label">{{ trans('labels.IBAN') }}
                                                </label>
                                                <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bank_iban', '',
                                                    array('class'=>'form-control field-validate',
                                                    'id'=>'bank_iban'))!!}
                                                    <span class="help-block"
                                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.IBAN Text') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name"
                                                    class="col-sm-2 col-md-3 control-label">{{ trans('labels.Swift') }}
                                                </label>
                                                <div class="col-sm-10 col-md-8">
                                                    {!! Form::text('bank_swift', '',
                                                    array('class'=>'form-control field-validate',
                                                    'id'=>'bank_swift'))!!}
                                                    <span class="help-block"
                                                        style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.Swift Text') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                          

                                            <div class="box-footer text-center">
                                              <a href="{{ URL::to('admin/deliveryboys/display')}}" type="button" class="btn btn-default pull-left">{{ trans('labels.back') }}</a>
                                              <button type="submit" class="btn btn-primary pull-right">{{ trans('labels.Adddeliveryboy') }}</button>
                                            </div>

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

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyDtBzgt0DV1-01ikDNSJfYppsDIkKfqApM"></script>
<script type="text/javascript">

var geocoder = new google.maps.Geocoder();
var address = "new york";

geocoder.geocode( { 'address': address}, function(results, status) {

if (status == google.maps.GeocoderStatus.OK) {
    var latitude = results[0].geometry.location.latitude;
    var longitude = results[0].geometry.location.longitude;
    alert(latitude);
    } 
}); 
</script>
@endsection
