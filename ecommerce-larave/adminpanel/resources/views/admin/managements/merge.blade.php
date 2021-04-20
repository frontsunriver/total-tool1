@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Merge Project') }} <small>{{ trans('labels.Merge Project') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Merge Project') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.Merge Project') }}</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <!-- @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif -->

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

                                            {!! Form::open(array('url' =>'admin/managements/mergecontent', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            
                                            <?php
                                                $execution_time = ini_get('max_execution_time');
                                                $upload_size = ini_get('upload_max_filesize'); 
                                                $upload_size = str_replace('M','',$upload_size);

                                                $post_size = ini_get('post_max_size');  
                                                $post_size = str_replace('M','',$post_size);     

                                               //if($execution_time < 180 and $upload_size < 128 and $post_size < 128){

                                               
                                            ?>
                                            <div class="form-group" id="imageIcone">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.NOTE') }}</label>
                                                <p class="col-sm-10 col-md-4">Your maximum file upload size, post max size and execution time do not match to the given requirements. Please fix it. Otherwise you will face problem while merging project.
                                                </br>
                                                <strong>Max Execution Time:</strong> 180 </br>
                                                <strong>Upload File Size:</strong> 128M</br>
                                                <strong>Post Max Size:</strong> 128M </p>
                                            </div>
                                            <?php
                                               // }
                                            ?>

                                            <div class="form-group" id="imageIcone">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Choose Zip') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="file" name="zip_file" id="file" class="form-control field-validate">
                                                    <span class="help-block">{{ trans('labels.Text for upload zip file') }}</span>
                                                </div>
                                            </div>

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
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
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
@endsection
