@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Login Setting') }} <small>{{ trans('labels.Login Setting') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Login Setting') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.Login Setting') }} </h3>
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
                                                        {{ $error }}
                                                    </div>
                                                @endforeach
                                            @endif

                                            {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                            <br>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.emaillogin') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="email_login" class="form-control">
                                                        <option @if($result['commonContent']['setting']['email_login'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.enable') }}</option>
                                                        <option @if($result['commonContent']['setting']['email_login'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.disable') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.emaillogintext') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.phonelogin') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="phone_login" class="form-control">
                                                        <option @if($result['commonContent']['setting']['phone_login'] == '1')
                                                                selected
                                                                @endif
                                                                value="1"> {{ trans('labels.enable') }}</option>
                                                        <option @if($result['commonContent']['setting']['phone_login'] == '0')
                                                                selected
                                                                @endif
                                                                value="0"> {{ trans('labels.disable') }}</option>

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.phonelogintext') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.verificationstype') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="phone_verificatio_type" class="form-control">
                                                        <option @if($result['commonContent']['setting']['phone_verificatio_type'] == 'firebase')
                                                                selected
                                                                @endif
                                                                value="firebase"> {{ trans('labels.phonefirebase') }}</option>
                                                        <!-- <option @if($result['commonContent']['setting']['phone_verificatio_type'] == 'twillio')
                                                                selected
                                                                @endif
                                                                value="twillio"> {{ trans('labels.twillio') }}</option> -->

                                                    </select>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.verificationstypetext') }}</span>
                                                </div>
                                            </div>

                                            

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
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
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
