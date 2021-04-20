@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.AddCustomer') }} <small>{{ trans('labels.AddNEWCustomer') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/customers/display')}}"><i class="fa fa-users"></i> {{ trans('labels.ListingAllCustomers') }}</a></li>
            <li class="active">{{ trans('labels.AddCustomer') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.AddCustomer') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!--<div class="box-header with-border">
                                          <h3 class="box-title">Edit category</h3>
                                        </div>-->
                                    <!-- /.box-header -->
                                    <br>
                                    @if (session('update'))
                                    <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong> {{ session('update') }} </strong>
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
                                        {!! Form::open(array('url' =>'admin/customers/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                                                        <div class="form-group">
                                                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FirstName') }} </label>
                                                                          <div class="col-sm-10 col-md-4">
                                                                            {!! Form::text('customers_firstname',  '', array('class'=>'form-control field-validate', 'id'=>'customers_firstname')) !!}
                                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.FirstNameText') }}</span>
                                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                          </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.LastName') }} </label>
                                                                          <div class="col-sm-10 col-md-4">
                                                                            {!! Form::text('customers_lastname',  '', array('class'=>'form-control field-validate', 'id'=>'customers_lastname')) !!}
                                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.lastNameText') }}</span>
                                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                          </div>
                                                                        </div>
                                                                        
                                                                          
                                                                        
                                                                        <div class="form-group">
                                                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Telephone') }}</label>
                                                                          <div class="col-sm-10 col-md-4">
                                                                            {!! Form::text('customers_telephone',  '', array('class'=>'form-control phone-validate', 'id'=>'customers_telephone')) !!}
                                                                           <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                           {{ trans('labels.TelephoneText') }}</span>
                                                                          </div>
                                                                        </div>
                                                                        <!-- <div class="form-group">
                                                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Fax') }}</label>
                                                                          <div class="col-sm-10 col-md-4">
                                                                            {!! Form::text('customers_fax',  '', array('class'=>'form-control', 'id'=>'customers_fax')) !!}
                                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.FaxText') }}</span>
                                                                          </div>
                                                                        </div> -->
                                                                        <hr>
                                                                        <div class="form-group">
                                                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.EmailAddress') }} </label>
                                                                          <div class="col-sm-10 col-md-4">
                                                                            {!! Form::text('email',  '', array('class'=>'form-control email-validate', 'id'=>'email')) !!}
                                                                             <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                             {{ trans('labels.EmailText') }}</span>
                                                                            <span class="help-block hidden"> {{ trans('labels.EmailError') }}</span>
                                                                          </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Password') }}</label>
                                                                          <div class="col-sm-10 col-md-4">
                                                                            {!! Form::password('password', array('class'=>'form-control field-validate', 'id'=>'password')) !!}
                                                        	                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                           {{ trans('labels.PasswordText') }}</span>
                                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                          </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                                                          <div class="col-sm-10 col-md-4">
                                                                            <select class="form-control" name="isActive">
                                                                                  <option value="1">{{ trans('labels.Active') }}</option>
                                                                                  <option value="0">{{ trans('labels.Inactive') }}</option>
                                        									</select>
                                                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                          {{ trans('labels.StatusText') }}</span>
                                                                          </div>
                                                                        </div>
                                                                        <div class="box-footer text-center">
                                                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                                            <a href="{{ URL::to('admin/customers/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
@endsection
