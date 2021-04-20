@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Inventory') }} <small>{{ trans('labels.Inventory') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/products/display') }}">{{ trans('labels.ListingAllProducts') }}</a></li>
            @if($result['products'][0]->products_type==1)
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
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.addinventory') }} </h3>

                    </div>
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
                                <div class="box box-info">
                                    <!-- form start -->
                                    <div class="box-body">
                                        <h4><strong>{{ trans('labels.productName') }}:</strong> {{ $result['products'][0]->products_name }}</h4>
                                        <br>

                                        <div class="row">
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
                                                                <div class="box-tools pull-right">

                                                                </div>
                                                            </div>
                                                            <!-- /.box-header -->
                                                            <div class="box-body">
                                                                {!! Form::open(array('url' =>'admin/products/inventory/addnewstock', 'name'=>'inventoryfrom', 'id'=>'addewinventoryfrom', 'method'=>'post', 'class' => 'form-horizontal form-validate',
                                                                'enctype'=>'multipart/form-data')) !!}
                                                                {!! Form::hidden('products_id', $result['products'][0]->products_id, array('class'=>'form-control', 'id'=>'products_id')) !!}

                                                                @if(count($result['attributes'])==0 and $result['products'][0]->products_type==1)
                                                                <div class="alert alert-danger" role="alert">
                                                                    {{ trans('labels.You can not add stock without attribute for variable product') }}
                                                                </div>
                                                                @endif

                                                                @if($result['products'][0]->products_type==1)
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.products_attributes') }}</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <ul class="list-group list-group-root well list-group-root2">
                                                                            @foreach ($result['attributes'] as $attribute)
                                                                            <li href="#" class="list-group-item"><label style="width:100%">
                                                                                    <input id="attribute" type="hidden" class="attributeid_<?=$attribute['option']['id']?>" name="attributeid[]" value=""> {{ $attribute['option']['name']}}</label></li>
                                                                            <ul class="list-group">
                                                                                <li class="list-group-item">
                                                                                    @foreach ($attribute['values'] as $value)<label><input name="values_<?=$attribute['option']['id']?>" type="radio" class="currentstock required_one" value="{{ $value['products_attributes_id'] }}"
                                                                                          attributeid="{{ $attribute['option']['id'] }}"> {{ $value['value'] }}</label> @endforeach</li>
                                                                            </ul>
                                                                            @endforeach
                                                                        </ul>
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Select Option values Text') }}.</span>
                                                                        <span class="help-block hidden">{{ trans('labels.Select Option values Text') }}</span>
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                 <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Current Stock') }}                             	 
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <p id="current_stocks" style="width:100%">{{$result['stocks']}}</p><br>
                                                                                                    
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Total Purchase Price') }}                              	 
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <p class="purchase_price_content" style="width:100%">
                                                                            @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                                                                            <span id="total_purchases">{{$result['purchase_price']}}</span></p><br>
                                                                                                    
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Current Stock') }}
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <p id="current_stocks" style="width:100%">{{$result['stocks']}}</p><br>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Total Purchase Price') }}
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <p class="purchase_price_content" style="width:100%">@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif<span id="total_purchases">{{$result['purchase_price']}}</span></p><br>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Enter Stock') }}</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="stock" value="" class="form-control number-validate">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Enter Stock Text') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Purchase Price') }}</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="purchase_price" value="" class="form-control number-validate">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Purchase Price Text') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">{{ trans('labels.Reference / Purchase Code') }}</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="reference_code" value="" class="form-control field-required">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Reference / Purchase Code Text') }}</span>
                                                                    </div>
                                                                </div>

                                                                <!-- /.users-list -->
                                                            </div>
                                                            @if(count($result['attributes'])>0 and $result['products'][0]->products_type==1 or $result['products'][0]->products_type==0)
                                                            <!-- /.box-body -->
                                                            <div class="box-footer text-center">
                                                                <button type="submit" class="btn btn-primary pull-right">{{ trans('labels.Add Stock') }}</button>
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

                                            <div class="col-md-6">
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
                                                                {!! Form::hidden('products_id', $result['products'][0]->products_id, array('class'=>'form-control', 'id'=>'products_id')) !!}

                                                                @if($result['products'][1]->products_type==1)
                                                                {!! Form::hidden('inventory_ref_id', '', array('class'=>'form-control check_reference_id', 'id'=>'inventory_ref_id')) !!}
                                                                @endif


                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Min Level') }}
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="min_level" id="min_level" value="{{$result['min_level']}}" class="form-control number-validate-level">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Min Level Text') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-4 control-label">
                                                                        {{ trans('labels.Max Level') }}
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="max_level" id="max_level" value="{{$result['max_level']}}" class="form-control number-validate-level">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.Min Level Text') }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="alert alert-danger alert-dismissible" id="minmax-error" role="alert" style="display: none">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    {{ trans('labels.This stock is not asscociated with any attributes. Please choose products attributes first') }}
                                                                </div>
                                                                <!-- /.users-list -->
                                                            </div>
                                                            <!-- /.box-body -->
                                                            <div class="box-footer text-center">
                                                                <button type="submit" class="btn btn-primary pull-right">{{ trans('labels.Submit') }}</button>
                                                            </div>

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
                                                @if($result['products'][0]->products_type==1)
                                                <a href="{{ URL::to("admin/products/attach/attribute/display/".$result['products'][0]->products_id) }}" class="btn btn-default pull-left">{{ trans('labels.AddOptions') }}</a>
                                                @else
                                                <a href="{{ URL::to("admin/products/display")}}" class="btn btn-default pull-left"> <i class="fa fa-angle-left"></i> {{ trans('labels.back') }}</a>
                                                @endif
                                                <a href="{{ URL::to("admin/products/images/display/{$result['products'][0]->products_id}")}}" class="btn btn-primary pull-right"> {{ trans('labels.Save_And_Continue') }} <i class="fa fa-angle-right"></i></a>
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
