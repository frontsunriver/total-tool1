@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  {{ trans('labels.ShippingMethods') }} <small>{{ trans('labels.ShippingMethods') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.ShippingMethods') }}</li>
            </ol>
        </section>

        <!--  content -->
        <section class="content">
            <!-- Info boxes -->
            {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
            <div class="box">
                <div class="box-header">
                @if (count($errors) > 0)
                    @if($errors->any())
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{$errors->first()}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                    <label for="name">{{ trans('labels.Free Shipping On Min Order Price') }}</label>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-md-4">
                            {!! Form::text('free_shipping_limit', $result['commonContent']['setting']['free_shipping_limit'], array('class'=>'form-control', 'id'=>'free_shipping_limit')) !!}<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">
                                {{ trans('labels.Free Shipping On After Order Price Text') }}</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                </div>                     
           </div>
            <!-- /.box-body -->
           
            {!! Form::close() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> {{ trans('labels.ShippingMethods') }} </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            

                            <div class="row default-div hidden">
                                <div class="col-xs-12">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                                        {{ trans('labels.ShippingMethodsChangedMessage') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center;">{{ trans('labels.Default') }}</th>
                                            <th style="text-align: center;">{{ trans('labels.ShippingTitle') }}</th>
                                            <th style="text-align: center;">{{ trans('labels.Price') }}</th>
                                            <th style="text-align: center;">{{ trans('labels.Status') }}</th>
                                            <th style="text-align: center;">{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($result['shipping_methods'] as $key=>$shipping_methods)
                                            <tr>
                                                <td>
                                                    <label>
                                                        <input type="radio" name="shipping_methods_id" value="1" shipping_id = '{{ $shipping_methods->shipping_methods_id}}' class="default_method" @if($shipping_methods->isDefault==1) checked @endif >
                                                    </label>
                                                </td>
                                                <td>
                                                    {{ $shipping_methods->name }}
                                                </td>
                                                @if($shipping_methods->methods_type_link=='upsShipping' and $shipping_methods->shipping_methods_id=='1')

                                                    <td>---</td>
                                                    <td>
                                                        @if($shipping_methods->status==0)
                                                            <span class="label label-warning">
                                                            	{{ trans('labels.InActive') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=no" class="method-status">
                                                                {{ trans('labels.InActive') }}
                                                            </a>
                                                        @endif
                                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                                        @if($shipping_methods->status==1)
                                                            <span class="label label-success">
                                                            	{{ trans('labels.Active') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=yes" class="method-status">
                                                                {{ trans('labels.Active') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ $shipping_methods->methods_type_link }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </td>
                                                @endif

                                                @if($shipping_methods->methods_type_link=='freeShipping' and $shipping_methods->shipping_methods_id=='2')
                                                    <td>---</td>
                                                    <td>
                                                        @if($shipping_methods->status==0)
                                                            <span class="label label-warning">
                                                            	{{ trans('labels.InActive') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=no" class="method-status">
                                                                {{ trans('labels.InActive') }}
                                                            </a>
                                                        @endif
                                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                                        @if($shipping_methods->status==1)
                                                            <span class="label label-success">
                                                            	{{ trans('labels.Active') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=yes" class="method-status">
                                                                {{ trans('labels.Active') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ URL::to("admin/shippingmethods/detail/".$shipping_methods->table_name)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                                @endif

                                                @if($shipping_methods->methods_type_link=='localPickup' and $shipping_methods->shipping_methods_id=='3')
                                                    <td>---</td>
                                                    <td>
                                                        @if($shipping_methods->status==0)
                                                            <span class="label label-warning">
                                                            	{{ trans('labels.InActive') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=no" class="method-status">
                                                                {{ trans('labels.InActive') }}
                                                            </a>
                                                        @endif
                                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                                        @if($shipping_methods->status==1)
                                                            <span class="label label-success">
                                                            	{{ trans('labels.Active') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=yes" class="method-status">
                                                                {{ trans('labels.Active') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ URL::to("admin/shippingmethods/detail/".$shipping_methods->table_name)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                                @endif

                                                @if($shipping_methods->methods_type_link=='flateRate' and $shipping_methods->shipping_methods_id=='4')
                                                    <td>{{ $result['flate_rate']['flate_rate']->currency }}{{ $result['flate_rate']['flate_rate']->flate_rate }} </td>
                                                    <td>
                                                        @if($shipping_methods->status==0)
                                                            <span class="label label-warning">
                                                            	{{ trans('labels.InActive') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=no" class="method-status">
                                                                {{ trans('labels.InActive') }}
                                                            </a>
                                                        @endif
                                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                                        @if($shipping_methods->status==1)
                                                            <span class="label label-success">
                                                            	{{ trans('labels.Active') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=yes" class="method-status">
                                                                {{ trans('labels.Active') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ $shipping_methods->methods_type_link }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    </td>
                                                @endif

                                                @if($shipping_methods->methods_type_link=='shippingByWeight' and $shipping_methods->shipping_methods_id=='5')

                                                    <td>---</td>
                                                    <td>
                                                        @if($shipping_methods->status==0)
                                                            <span class="label label-warning">
                                                            	{{ trans('labels.InActive') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=no" class="method-status">
                                                                {{ trans('labels.InActive') }}
                                                            </a>
                                                        @endif
                                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                                                        @if($shipping_methods->status==1)
                                                            <span class="label label-success">
                                                            	{{ trans('labels.Active') }}
                                                            </span>
                                                        @else
                                                            <a href="{{ URL::to("admin/shippingmethods/display")}}?id={{ $shipping_methods->shipping_methods_id}}&active=yes" class="method-status">
                                                                {{ trans('labels.Active') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ URL::to("admin/shippingmethods/detail/".$shipping_methods->table_name)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                                    <td> <a href="{{ URL::to('admin/shippingmethods/shppingbyweight/')}}" class="badge bg-light-blue">{{ trans('labels.Manage Weight') }}</a>    </td>                              </td>
                                                @endif

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
        </section>
        <!-- /.content -->
    </div>
@endsection
