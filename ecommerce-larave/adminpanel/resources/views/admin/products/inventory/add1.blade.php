@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Inventory') }} <small>{{ trans('labels.Inventory') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/products/display') }}"><i class="fa fa-database"></i> {{ trans('labels.ListingAllProducts') }}</a></li>
            @if(count($result['products'])> 0 && $result['products'][0]->products_type==1)
            <li><a href="{{ URL::to('admin/products/attach/attribute/display/'.$result['products'][0]->products_id) }}">{{ trans('labels.AddOptions') }}</a></li>
            @endif
            <li class="active">{{ trans('labels.Inventory') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.addinventory') }} </h3>

                    </div> -->
                    <div class="box-body">

                        <div class="row">
                            <div class="col-xs-12">
                               

                                @if(session()->has('message.level'))
                                    <div class="alert alert-{{ session('message.level') }} alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {!! session('message.content') !!}
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <div class="box-body">
                                    <div class="col-md-12">
                                    {!! Form::open(array('url' =>'admin/products/inventory/addnewstock', 'name'=>'inventoryfrom', 'id'=>'addewinventoryfrom', 'method'=>'post', 'class' => 'form-horizontal form-validate',
                                                                'enctype'=>'multipart/form-data')) !!}
                                    <div class="form-group" >
                                        <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Products') }}<span style="color:red;">*</span> </label>
                                        <div class="col-sm-6 col-md-6">
                                            <select class="form-control field-validate product-type" name="products_id">
                                                <option value="">{{ trans('labels.Choose Product') }}</option>
                                                @foreach ($result['products'] as $pro)
                                                <option value="{{$pro->products_id}}">{{$pro->products_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                {{ trans('labels.Product Type Text') }}.
                                            </span>
                                        </div>
                                    </div>
                                    <div id="attribute" style="display:none">

                                    </div>
                                    </div>
                                        <div class="row" id="form_div" style="display:none">
                                            <!-- Left col -->
                                            <div class="col-md-6">
                                                <!-- MAP & BOX PANE -->

                                                <!-- /.box -->
                                                <div class="row">
                                                    <!-- /.col -->
                                                    <div class="col-md-12">
                                                        <!-- USERS LIST -->
                                                        <div class="box box-info">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title">{{ trans('labels.Add Stock') }}</h3>
                                                                <div class="box-tools">

                                                                </div>
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <div class="box-body">
                                                               

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Current Stock') }}
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="hidden" id="current_stocks_val"  name="current_stocks_input" value=""/>
                                                                        <p id="current_stocks" style="width:100%">0</p><br>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.stocktype') }} </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                    <select class="form-control" name="stock_type">
                                                                            <option value="in">{{ trans('labels.in') }}</option>
                                                                            <option value="out">{{ trans('labels.out') }}</option>
                                                                        </select>
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.stocktypetext') }}</span>


                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Enter Stock') }}<span style="color:red;">*</span></label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="stock" value="" class="form-control stock-validate">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Enter Stock Text') }}</span>
                                                                    </div>
                                                                </div>

                                                             

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Reference') }}</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="reference_code" value="" class="form-control">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Reference Text') }}</span>
                                                                    </div>
                                                                </div>

                                                                <!-- /.users-list -->
                                                            </div>
                                                           @if(count($result['products'])> 0)
                                                                @if(count($result['attributes'])>0 and $result['products'][0]->products_type==1 or $result['products'][0]->products_type==0)
                                                                <!-- /.box-body -->
                                                                <div class="box-footer text-center">
                                                                    <button type="submit" id="attribute-btn" class="btn btn-primary pull-right">{{ trans('labels.Add Stock') }}</button>
                                                                </div>
                                                                @endif
                                                            @endif

                                                            {!! Form::close() !!}
                                                            <!-- /.box-footer -->
                                                        </div>
                                                        <!--/.box -->
                                                    </div>

                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->

                                                
                                            </div>

                                            <div class="col-md-6" >
                                                <!-- MAP & BOX PANE -->

                                                <!-- /.box -->
                                                <div class="row">
                                                    <!-- /.col -->
                                                    <div class="col-md-12">
                                                        <!-- USERS LIST -->
                                                        <div class="box box-danger">
                                                            <div class="box-header with-border">
                                                                <h3 class="box-title">{{ trans('labels.Manage Min/Max Quantity') }}</h3>
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <div class="box-body">
                                                                {!! Form::open(array('url' =>'admin/products/inventory/addminmax', 'name'=>'addminmax', 'id'=>'addminmax', 'method'=>'post', 'class' => 'form-horizontal form-validate-level',
                                                                'enctype'=>'multipart/form-data')) !!}
                                                                 <input class="form-control check_reference_id" id="inventory_ref_id" name="inventory_ref_id" type="hidden" value="">
                                                                 <input class="form-control check_reference_id" id="inventory_pro_id" name="products_id" type="hidden" value="">

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Min Level') }}<span style="color:red;">*</span>
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="min_level" id="min_level" value="" class="form-control number-validate-level">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Min Level Text') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Max Level') }}<span style="color:red;">*</span>
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="max_level" id="max_level" value="" class="form-control number-validate-level">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Max Level Text') }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="alert alert-danger alert-dismissible" id="minmax-error" role="alert" style="display: none">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    {{ trans('labels.This stock is not asscociated with any attributes. Please choose products attributes first') }}
                                                                </div>
                                                                <!-- /.users-list -->
                                                            </div>
                                                            <!-- /.box-body -->
                                                            @if(count($result['products'])> 0)
                                                            <div class="box-footer text-center">
                                                                <button type="submit" class="btn btn-primary pull-right">{{ trans('labels.Submit') }}</button>
                                                            </div>
                                                            @endif

                                                            {!! Form::close() !!}
                                                            <!-- /.box-footer -->
                                                        </div>
                                                        <!--/.box -->
                                                    </div>

                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.row -->
                                            </div>

                                            <div class="box-footer col-xs-12">
                                                @if(count($result['products'])> 0 && $result['products'][0]->products_type==1)
                                                <a href="{{ URL::to("admin/products/attach/attribute/display/".$result['products'][0]->products_id) }}" class="btn btn-default pull-left">{{ trans('labels.AddOptions') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>


    </section>
    <!-- /.row -->

    <!-- Main row -->
</div>

<!-- /.row -->

@endsection
