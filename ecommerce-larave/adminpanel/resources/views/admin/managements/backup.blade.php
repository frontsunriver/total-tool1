@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Back Up / Restore') }} <small>{{ trans('labels.Back Up / Restore') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Back Up / Restore') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.Back Up / Restore') }}</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">

                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                    @if(session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/managements/take_backup', 'id' =>'updater-form', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                            <div class="form-group" id="imageIcone">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Purchase Code') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="text" name="purchase_code"  class="form-control field-validate">
                                                    <span class="help-block">{{ trans('labels.Purchase Code Text') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="button" class="btn btn-primary" id="password-confirm-btn" >{{ trans('labels.Take Back Up') }}</button>
                                                </div>
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

    <div class="modal fade" id="checkpassword" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p style="text-align:center">{{ trans('labels.Update source code confirm password text') }}</p>
                <div class="form-group" id="imageIcone">
                    <label for="name" class="col-sm-3 col-md-4 control-label">{{ trans('labels.Password') }}</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="alert alert-danger" id="passowrd-error" style="display: none">
                    {{ trans('labels.Please enter your valid passowrd.') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="check-password">{{ trans('labels.Confirm') }}</button>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
