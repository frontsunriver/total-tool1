@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!--->
  <section class="content-header">
    <h1> {{ trans('labels.AdminProfile') }} </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.AdminProfile') }} </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

      <div class="row">

        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">{{ trans('labels.Profile') }}</a></li>
              <li><a href="#passwordDiv" data-toggle="tab">{{ trans('labels.Password') }}</a></li>
            </ul>
            <div class="tab-content">
              <div class=" active tab-pane" id="profile">

            	  @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{$errors->first()}}
                    </div>
                @endif
                <!-- The timeline -->
                   {!! Form::open(array('url' =>'admin/admin/update', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                      {!! Form::hidden('myid', auth()->user()->myid, array('class'=>'form-control', 'id'=>'myid'))!!}

                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">{{ trans('labels.AdminFirstName') }}</label>
                        <div class="col-sm-10">
                          {!! Form::text('first_name', Auth()->user()->first_name, array('class'=>'form-control', 'id'=>'first_name'))!!}
                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                          {{ trans('labels.AdminFirstNameText') }}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">{{ trans('labels.LastName') }}</label>

                        <div class="col-sm-10">
                          {!! Form::text('last_name', auth()->user()->last_name, array('class'=>'form-control', 'id'=>'last_name'))!!}
                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                          {{ trans('labels.AdminLastNameText') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">{{ trans('labels.Address') }} </label>
                        <div class="col-sm-10">
                          {!! Form::text('address', $result['admin']->entry_street_address, array('class'=>'form-control', 'id'=>'address'))!!}
                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                          {{ trans('labels.AddressText') }}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">{{ trans('labels.City') }}
                        </label>

                        <div class="col-sm-10">
                         {!! Form::text('city', $result['admin']->entry_city, array('class'=>'form-control', 'id'=>'city'))!!}
                         <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CityText') }}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">{{ trans('labels.Country') }}</label>
    					           <div class="col-sm-10">
                            <select class="form-control" name="country" id="entry_country_id">
                            	<option value="">{{ trans('labels.SelectCountry') }}</option>
                            	@foreach($result['countries'] as $countries)
                            		<option @if($result['admin']->entry_country_id==$countries->countries_id) selected @endif value="{{ $countries->countries_id }}">{{ $countries->countries_name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CountryText') }}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputSkills" class="col-sm-2 control-label">{{ trans('labels.State') }}</label>
    					             <div class="col-sm-10">
                           <select class="form-control zoneContent" name="state">
                            	<option value="">{{ trans('labels.SelectZone') }}</option>
                            	@foreach($result['zones'] as $zones)
                            		<option @if($result['admin']->entry_state==$zones->zone_id) selected @endif value="{{ $zones->zone_id }}">{{ $zones->zone_name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.SelectZoneText') }}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">{{ trans('labels.ZipCode') }}</label>

                        <div class="col-sm-10">
                         {!! Form::text('zip', $result['admin']->entry_postcode, array('class'=>'form-control', 'id'=>'zip'))!!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">{{ trans('labels.Phone') }}</label>

                        <div class="col-sm-10">
                         {!! Form::text('phone', auth()->user()->phone, array('class'=>'form-control', 'id'=>'phone'))!!}
                         <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                         {{ trans('labels.PhoneText') }}</span>
                        </div>
                      </div>


                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success">{{ trans('labels.Submit') }}</button>
                        </div>
                      </div>
                    {!! Form::close() !!}
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="passwordDiv">
                 {!! Form::open(array('url' =>'admin/admin/updatepassword', 'onSubmit'=>'return validatePasswordForm()', 'id'=>'updateAdminPassword', 'name'=>'updateAdminPassword' , 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                  <div class="form-group form-group-email">
                    <label for="email" class="col-sm-2 control-label">{{ trans('labels.Email') }}</label>
					          <div class="col-sm-10">
                      <input type="text" class="form-control" id="email" value="{{$result['admin']->email}}" name="email" placeholder="email">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">{{ trans('labels.NewPassword') }}</label>
					          <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="re-password" class="col-sm-2 control-label">{{ trans('labels.Re-EnterPassword') }}</label>
					          <div class="col-sm-10">
                      <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Re-Enter Password">
                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AdminPasswordRestriction') }}</span>
                      <span style="display: none" class="help-block"></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">{{ trans('labels.Submit') }}</button>
                    </div>
                  </div>
                </form>
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
