@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Add Currency') }} <small>{{ trans('labels.Add Currency') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/currencies/display')}}"><i
                        class="fa fa-gears"></i>{{ trans('labels.Currency') }}</a></li>
            <li class="active">{{ trans('labels.Add Currency') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.Add Currency') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <br>
                                    @if (count($errors) > 0)
                                    @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                    </div>
                                    @endif
                                    @endif
                                    @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ session()->get('success') }}
                                    </div>
                                    @endif
                                    <div class="box-body">

                                        {!! Form::open(array('url' =>'admin/currencies/add', 'method'=>'post', 'class'
                                        => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        <div class="form-group">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.title') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('title', '', array('class'=>'form-control
                                                field-validate', 'id'=>'title'))!!}
                                                <span class="help-block"
                                                    style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.title') }}</span>
                                                <span
                                                    class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.Country') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control field-validate" name="code">
                                                    @foreach($currencies as $currency)
                                                    <option value="{{$currency->code}}">{{ $currency->currency_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block"
                                            style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.Choose Country') }}</span>
                                            </div>
                                            
                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.symbol') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('symbol', '', array('class'=>'form-control field-validate',
                                                'id'=>'symbol'))!!}
                                                <span class="help-block"
                                                    style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.symbol text') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.Position') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="position">
                                                    <option value="left">{{ trans('labels.Left') }}</option>
                                                    <option value="right">{{ trans('labels.Right') }}</option>
                                                </select>
                                                <span class="help-block"
                                            style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.Choose position of the currency') }}</span>
                                            </div>
                                            
                                            
                                        </div>                                        

                                        <div class="form-group" style="display: none">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.decimal_point') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('decimal_point', '', array('class'=>'form-control',
                                                'id'=>'decimal_point'))!!}
                                                <span class="help-block"
                                                    style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.decimal_point') }}</span>
                                                <span
                                                    class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: none">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.thousands_point') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('thousands_point', '', array('class'=>'form-control',
                                                'id'=>'thousands_point'))!!}
                                                <span class="help-block"
                                                    style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.thousands_point') }}</span>
                                                <span
                                                    class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.decimal_places') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('decimal_places', '', array('class'=>'form-control
                                                field-validate', 'id'=>'decimal_places'))!!}
                                                <span class="help-block"
                                                    style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.decimal_places') }}</span>
                                                <span
                                                    class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.value') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('value', '', array('class'=>'form-control
                                                field-validate', 'id'=>'value'))!!}
                                                <span class="help-block"
                                                    style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.value') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="status">
                                                    <option value="1">{{ trans('labels.Active') }}</option>
                                                    <option value="0">{{ trans('labels.InActive') }}</option>
                                                </select>
                                                <span class="help-block"
                                                    style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.StatusBannerText') }}</span>
                                            </div>
                                        </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit"
                                                class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                            <a href="{{ URL::to('admin/currencies/display')}}" type="button"
                                                class="btn btn-default">{{ trans('labels.back') }}</a>
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
