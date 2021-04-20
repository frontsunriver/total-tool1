@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Sattlements History') }}
            {{$result['earningsbymonth']['vendors']}}<small> {{ trans('labels.Sattlements History') }}
                {{$result['earningsbymonth']['vendors']}}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/finance/display')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.Earning') }}</a></li>
            <li class="active"> {{ trans('labels.Sattlements History') }}
                {{$result['earningsbymonth']['vendors']}}</li>
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
                        <h3 class="box-title"> {{ trans('labels.Sattlements History') }}
                            {{$result['earningsbymonth']['vendors']}}</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="row">


                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{ trans('labels.OrderID') }}</th>
                                            <th>{{ trans('labels.Date') }}</th>
                                            <th>{{ trans('labels.ProductsPrice') }}</th>
                                            <th>{{ trans('labels.ShippingCost') }}</th>
                                            <th>{{ trans('labels.CouponAmount') }}</th>
                                            <th>{{ trans('labels.Total Amount') }}</th>
                                            <th>{{ trans('labels.Admin Commission') }}</th>
                                            <th>{{ trans('labels.Vendor Earning') }}</th>
                                            <!-- <th>{{ trans('labels.Action') }}</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(count($result['earningsbymonth']['sale_data'])>0)
                                        @foreach ($result['earningsbymonth']['sale_data'] as $key=>$monthlyearning)
                                        <tr>
                                        <td><button type="button" class="btn btn-gray accordion-toggle" data-toggle="collapse" data-target="#{{$key}}_collapse" aria-expanded="true"><span class="fa fa-angle-down fa-lg"></span></button></td>
                                            <td>{{ $monthlyearning['orders_id'] }}</td>
                                            <td>{{ $monthlyearning['month'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['item_price'] }}
                                            </td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['shipping_cost'] }}
                                            </td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['coupon_amount'] }}
                                            </td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['total_amount'] }}
                                            </td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['admin_commision'] }}
                                            </td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['vendor_balance'] }}
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="10" class="hiddenRow">
                                                <div class="accordian-body collapse" id="{{$key}}_collapse" data-order-id="47" aria-expanded="true" style="">
                                                    <table class="table innerdetail">

                                                        <tbody>
                                                            <tr>
                                                                <td colspan="" style="width: 20%">
                                                                    <p><strong>Vendor's Name </strong><br>
                                                                        {{$monthlyearning['vendors_data']->first_name}}
                                                                        {{$monthlyearning['vendors_data']->last_name}}
                                                                    </p>
                                                                    <p><strong>Vendor's Contact Number </strong><br>
                                                                    {{$monthlyearning['vendors_data']->phone}}
                                                                    </p>

                                                                </td>
                                                                <td colspan="" style="width: 20%">
                                                                    <p><strong>Customer's Name </strong><br>
                                                                        {{$monthlyearning['orders_data']->customers_name}}
                                                                    </p>
                                                                    <p><strong>Customer's Contact No.</strong><br>{{$monthlyearning['orders_data']->delivery_phone}}
                                                                    </p>

                                                                </td>
                                                                <td colspan="1" style="width: 20%">
                                                                    <p><strong>Driver's Name</strong><br>
                                                                        {{$monthlyearning['deliveryboy_data']->first_name}}
                                                                        {{$monthlyearning['deliveryboy_data']->last_name}}
                                                                    </p>
                                                                    <p><strong>Driver's Contact no</strong><br>9323196436
                                                                    </p>
                                                                </td>
                                                                <td colspan="1" style="width: 20%">                                                                    
                                                                    <p>
                                                                        <strong>Dlivery Time Slot</strong><br>                                                                        
                                                                        {{$monthlyearning['orders_data']->delivery_time}}
                                                                    </p>
                                                                </td>
                                                                <td colspan="1" style="width: 20%">                                                                    
                                                                    <p>
                                                                        <strong>Payment Details</strong><br>
                                                                        {{ $result['setting'][19]->value }}{{$monthlyearning['orders_data']->shipping_cost}}
                                                                    </p>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>

                                                </div>
                                            </td>

                                        </tr>
                                        @endforeach
                                        <!-- <tr>
                                            <td><strong>{{ trans('labels.TOTAL') }}</strong></td>
                                            <td>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['total_item_price'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['total_shipping_cost'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['total_coupon_amount'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['total_order_amount'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['total_admin_commision'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['total_vendor_balance'] }}</td>
                                            <td></td>                                            
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="font-size: 16px; text-align: right;"><strong>{{ trans('labels.Total Paid by customer') }}</strong></td>
                                            <td style="font-size: 16px;"><strong>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['online_orders'] }} ({{ trans('labels.Online') }})</strong></td>
                                            <td style="font-size: 16px;"><strong>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['cod_orders'] }}  ({{ trans('labels.COD') }})</strong></td>
                                            <td style="font-size: 16px;"><strong>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['total_order_amount'] }}</strong></td>
                                        </tr> -->
                                        @else
                                        <tr>
                                            <td colspan="7"><strong>{{ trans('labels.NoRecordFound') }}</strong></td>
                                        </tr>
                                        @endif
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

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection