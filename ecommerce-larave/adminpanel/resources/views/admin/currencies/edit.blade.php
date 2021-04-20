@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Edit Currency') }} <small>{{ trans('labels.Edit Currency') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/currencies/display')}}"><i class="fa fa-gears"></i> {{ trans('labels.Currency') }}</a></li>
            <li class="active">{{ trans('labels.Edit Currency') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.Edit Currency') }} </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
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
                                    @if(session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ session()->get('error') }}
                                    </div>
                                    @endif
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <div class="box-body">

                                        {!! Form::open(array('url' =>'admin/currencies/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        {!! Form::hidden('id', $result['currency']->id , array('class'=>'form-control', 'id'=>'id')) !!}
                                        <input type="hidden" name="warning" value="{{$result['warning']}}" />
                                        <div class="form-group">
                                            <label for="name"
                                                class="col-sm-2 col-md-3 control-label">{{ trans('labels.title') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('title', $result['currency']->title, array('class'=>'form-control
                                                field-validate', 'id'=>'title'))!!}
                                                <span class="help-block"
                                                    style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.title') }}</span>
                                                <span
                                                    class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Country') }} </label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control field-validate" name="code">
                                                  @foreach($currencies as $currency)
                                                    <option @if($result['currency']->code == $currency->code) selected @endif value="{{$currency->code}}">{{ $currency->currency_name }}</option>
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

                                                @if(!empty($result['currency']->symbol_left))
                                                    {!! Form::text('symbol', $result['currency']->symbol_left, array('class'=>'form-control field-validate',
                                                    'id'=>'symbol'))!!}
                                                @else
                                                    {!! Form::text('symbol', $result['currency']->symbol_right, array('class'=>'form-control field-validate',
                                                    'id'=>'symbol'))!!}
                                                @endif

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
                                                    <option value="left" @if(!empty($result['currency']->symbol_left)) selected @endif>{{ trans('labels.Left') }}</option>
                                                    <option value="right" @if(!empty($result['currency']->symbol_right)) selected @endif>{{ trans('labels.Right') }}</option>
                                                </select>
                                                <span class="help-block"
                                            style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.Choose position of the currency') }}</span>
                                            </div>  
                                        </div>    

                                        <div class="form-group" style="display: none">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.decimal_point') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('decimal_point',  $result['currency']->decimal_point, array('class'=>'form-control', 'id'=>'decimal_point'))!!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.decimal_point') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: none">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.thousands_point') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('thousands_point',  $result['currency']->thousands_point, array('class'=>'form-control', 'id'=>'thousands_point'))!!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.thousands_point') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" >
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.decimal_places') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('decimal_places',  $result['currency']->decimal_places, array('class'=>'form-control field-validate', 'id'=>'decimal_places'))!!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.decimal_places') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.value') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                @if($result['currency']->is_default==1)
                                                    {!! Form::text('value',  $result['currency']->value, array('class'=>'form-control field-validate', 'id'=>'value', 'readonly'=>'readonly'))!!}
                                                @else
                                                    {!! Form::text('value',  $result['currency']->value, array('class'=>'form-control field-validate', 'id'=>'value'))!!}
                                                @endif
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                   {{ trans('labels.value') }}</span>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                            <a href="{{ URL::to('admin/currencies/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                        </div>
                                        <!-- /.box-footer -->

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.box-body -->

        <!-- /.box -->

        <!-- /.col -->

        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
