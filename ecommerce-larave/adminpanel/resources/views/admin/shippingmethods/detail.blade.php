@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>@if($result['shppingMethods'][0]->table_name=='free_shipping')
                  {{ trans('labels.FreeShipping') }}
                @elseif($result['shppingMethods'][0]->table_name=='local_pickup')
                  {{ trans('labels.LocalPickup') }}
                @elseif($result['shppingMethods'][0]->table_name=='shipping_by_weight')
                  {{ trans('labels.shppingbyweight') }}
                @endif

                <small>
                  @if($result['shppingMethods'][0]->table_name=='free_shipping')
                    {{ trans('labels.FreeShipping') }}...
                  @elseif($result['shppingMethods'][0]->table_name=='local_pickup')
                  {{ trans('labels.LocalPickup') }}...
                  @elseif($result['shppingMethods'][0]->table_name=='shipping_by_weight')
                    {{ trans('labels.shppingbyweight') }}...
                  @endif
                </small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/shippingmethods/display')}}"><i class="fa fa-bars"></i> {{ trans('labels.Shipping Method') }}</a></li>
                <li class="active">
                  @if($result['shppingMethods'][0]->table_name=='free_shipping')
                    {{ trans('labels.FreeShipping') }}
                  @elseif($result['shppingMethods'][0]->table_name=='local_pickup') 
                    {{ trans('labels.LocalPickup') }}
                  @elseif($result['shppingMethods'][0]->table_name=='shipping_by_weight')
                    {{ trans('labels.shppingbyweight') }}
                  @endif</li>
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
                            <h3 class="box-title">
                              @if($result['shppingMethods'][0]->table_name=='free_shipping')
                                {{ trans('labels.FreeShipping') }}
                              @elseif($result['shppingMethods'][0]->table_name=='local_pickup')
                                {{ trans('labels.LocalPickup') }}
                              @elseif($result['shppingMethods'][0]->table_name=='shipping_by_weight')
                                {{ trans('labels.shppingbyweight') }}
                              @endif </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <br>
                                        @if (count($errors) > 0)
                                            @if($errors->any())
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    {{$errors->first()}}
                                                </div>
                                        @endif
                                    @endif
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/shippingmethods/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                            {!! Form::hidden('table_name',  $result['shppingMethods'][0]->table_name , array('class'=>'form-control', 'id'=>'table_name')) !!}
                                            @foreach($result['description'] as $description_data)
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} ({{ $description_data['language_name'] }})</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="name_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['name']}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ShippingmethodName') }} ({{ $description_data['language_name'] }}).</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>

                                            @endforeach


                                        <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/shippingmethods/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
