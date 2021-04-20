@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.ManageLabel') }} <small>{{ trans('labels.ManageLabel') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.ManageLabel') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.ManageLabel') }} </h3>
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
                                        @if (count($errors) > 0)
                                            @if($errors->any())
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    {{$errors->first()}}
                                                </div><br>

                                            @endif
                                        @endif

                                        @if(session()->has('message'))
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{ session()->get('message') }}
                                            </div><br>

                                        @endif
                                        <div class="box-tools pull-right">
                                            <a href="{{ URL::to('admin/addappkey')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewKey') }}</a>
                                        </div><br>

                                        <!-- form start -->
                                        <div class="box-body">
                                            @foreach ($result['labels'] as $key=>$data)

                                                {!! Form::open(array('url' =>'admin/updateAppLabel', 'name'=>'form', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                                @foreach ($data as $labels_data)

                                                    <?php $labels_data1 = $labels_data->values->toArray(); ?>
                                                    <hr>
                                                    <h4><strong>{{ trans('labels.LabelKey') }}:</strong> {{ $labels_data->label_name }}</h4>
                                                    <hr><br>

                                                    <?php $j=0;?>
                                                    @foreach($result['languages'] as $key=>$languages)
                                                        @if(!empty($labels_data1[$j]->language_id) and $languages->languages_id == $labels_data1[$j]->language_id)
                                                            <input type="hidden" name="label_id_<?=$labels_data->label_id?>" value="{{ $labels_data->label_id }}">

                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.LabelValue') }} ({{ $languages->name }})</label>
                                                                <div class="col-sm-10 col-md-10">
                                                                    <input type="text" name="label_value_<?=$languages->languages_id?>_<?=$labels_data->label_id?>" class="form-control" @if(!empty($labels_data1[$j]->language_id)) value="{{ $labels_data1[$j]->label_value}}" @endif>
                                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LabelValue') }} ({{ $languages->name }}).</span>
                                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                </div>
                                                            </div>

                                                        @else
                                                            <input type="hidden" name="label_id_<?=$labels_data->label_id?>" value="{{ $labels_data->label_id }}">

                                                            <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.LabelValue') }} ({{ $languages->name }})</label>
                                                                <div class="col-sm-10 col-md-10">
                                                                    <input type="text" name="label_value_<?=$languages->languages_id?>_<?=$labels_data->label_id?>" class="form-control">
                                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.LabelValue') }} ({{ $languages->name }}).</span>
                                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                </div>
                                                            </div>

                                                        @endif
                                                        <?php
                                                        $j++;
                                                        ?>

                                                    @endforeach
                                                @endforeach


                                            <!-- /.box-body -->
                                                <div class="box-footer text-center">
                                                    <a href="{{ URL::to('admin/dashboard/this_month')}}" type="button" class="pull-left btn btn-default">{{ trans('labels.back') }}</a>
                                                    <button type="submit" class="btn btn-primary pull-right">{{ trans('labels.Submit') }}</button>
                                                </div>
                                                <!-- /.box-footer -->
                                                {!! Form::close() !!}
                                            @endforeach
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