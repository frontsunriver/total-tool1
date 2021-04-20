

@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.MediaSetting') }}<small>{{ trans('labels.MediaTextSetting') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.ImageSize') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.ImageSize') }}</h3>
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
                                            @if (session('update'))
                                                <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong> {{ session('update') }} </strong>
                                                </div>
                                            @endif

                                        @if( count($errors) > 0)
                                                @foreach($errors->all() as $error)
                                                    <div class="alert alert-success" role="alert">
                                                        <span class="icon fa fa-check" aria-hidden="true"></span>
                                                        <span class="sr-only">{{ trans('labels.ImageSize') }}:</span>
                                                        {{ $error }}</div>
                                                @endforeach
                                            @endif

                                            {!! Form::open(array('url' =>'admin/media/updatemediasetting', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                                <h4>{{ trans('labels.ThumbnailSetting') }}</h4>
                                                <hr>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Thumbnail_height') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text($web_setting[87]->value,  $web_setting[87]->value, array('class'=>'form-control number-validate', 'id'=>$web_setting[87]->value, 'name'=>'ThumbnailHeight')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Thumbnail_height') }}</span>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Thumbnail_width') }}</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text($web_setting[88]->value,  $web_setting[88]->value, array('class'=>'form-control number-validate', 'id'=>$web_setting[88]->value, 'name'=>'ThumbnailWidth')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Thumbnail_width') }}</span>
                                                    </div>

                                              </div>

                                                <h4>{{ trans('labels.MediumSetting') }}</h4>
                                                <hr>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Medium_height') }}</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text($web_setting[89]->value,  $web_setting[89]->value, array('class'=>'form-control number-validate', 'id'=>$web_setting[89]->value, 'name'=>'MediumHeight')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Medium_height') }}</span>
                                                    </div>

                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Medium_width') }}</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text($web_setting[90]->value,  $web_setting[90]->value, array('class'=>'form-control number-validate', 'id'=>$web_setting[90]->value, 'name'=>'MediumWidth')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Medium_width') }}</span>
                                                    </div>

                                                </div>
                                                <h4>{{ trans('labels.LargeSetting') }}</h4>
                                                <hr>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Large_height') }}</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text($web_setting[91]->value,  $web_setting[91]->value, array('class'=>'form-control number-validate', 'id'=>$web_setting[91]->value, 'name'=>'LargeHeight')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Large_height') }}</span>
                                                    </div>

                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Large_width') }}</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text($web_setting[92]->value,  $web_setting[92]->value, array('class'=>'form-control number-validate', 'id'=>$web_setting[92]->value, 'name'=>'LargeWidth')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.Large_width') }}</span>
                                                    </div>

                                                </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                            <button type="submit" class="btn btn-success" id="regenrate" name="regenrate" value="yes">{{ trans('labels.SaveRegenerate') }}</button>
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
