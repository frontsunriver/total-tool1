@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.apiSetting') }} <small>{{ trans('labels.apiSetting') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.apiSetting') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.apiSetting') }} </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="box-body">
                                            <div class="alert alert-success" hidden id="generateSuccessfully" role="alert">
                                                <span class="icon fa fa-check" aria-hidden="true"></span>
                                                <span class="sr-only">{{ trans('labels.api') }}:</span>
                                                {{ trans('labels.updateapisettingmessage') }}
                                            </div>
                                            
                                            {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.consumerKey') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('consumer_key', $result['commonContent']['setting']['consumer_key'], array('readonly'=>'readonly', 'class'=>'form-control', 'id'=>'consumer_key')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.consumerKeyText') }}</span>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.consumerSecret') }}

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('consumer_secret',$result['commonContent']['setting']['consumer_secret'], array('readonly'=>'readonly', 'class'=>'form-control', 'id'=>'consumer_secret')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.consumerSecretText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-md-of fset-3 col-sm-10 col-md-4">
                                                    <button type="button" class="btn btn-success" id="generate-key">{{ trans('labels.generateKey') }} </button>
                                                </div>
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

    <!-- /.row -->

    <!-- Main row -->

    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
@endsection