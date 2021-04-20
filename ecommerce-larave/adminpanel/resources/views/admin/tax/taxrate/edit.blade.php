@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.EditTaxRate') }} <small>{{ trans('labels.EditTaxRate') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/tax/taxrates/display')}}"><i class="fa fa-dashboard"></i>{{ trans('labels.TaxRates') }}</a></li>
                <li class="active">{{ trans('labels.EditTaxRate') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.EditTaxRate') }}</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info"><br>
                                        @if(count($result['message'])>0)
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{ $result['message'] }}
                                            </div>
                                    @endif

                                    <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/tax/taxrates/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id', $result['taxrate']->tax_rates_id, array('class'=>'form-control', 'id'=>'tax_rate'))!!}
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.TaxClass') }}*  </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="tax_class_id" class="form-control">
                                                        @foreach($result['tax_class'] as $tax_class)
                                                            <option
                                                                    @if($result['taxrate']->tax_class_id == $tax_class->tax_class_id)
                                                                    selected
                                                                    @endif
                                                                    value="{{ $tax_class->tax_class_id }}"> {{ $tax_class->tax_class_title }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseTaxClass') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Zone') }}*
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="tax_zone_id" class="form-control">
                                                        @foreach($result['zones'] as $zones)
                                                            <option
                                                                    @if($result['taxrate']->tax_zone_id == $zones->zone_id)
                                                                    selected
                                                                    @endif
                                                                    value="{{ $zones->zone_id }}"> {{ $zones->zone_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRateText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.AddTaxRatePercentage') }}*
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('tax_rate',  $result['taxrate']->tax_rate, array('class'=>'form-control number-validate', 'id'=>'tax_rate'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddTaxRatePercentageText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.NumericValueError') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }}
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::textarea('tax_description',  $result['taxrate']->tax_description, array('class'=>'form-control', 'id'=>'tax_description'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.TaxDescription') }}</span>
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/tax/taxrates/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
