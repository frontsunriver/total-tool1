@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{$result['month']}} {{ trans('labels.Earning by Vendors') }} <small>{{$result['month']}} {{ trans('labels.Earning by Vendors') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/finance/display')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.Earning') }}</a></li>
            <li class="active">{{$result['month']}} {{ trans('labels.Earning by Vendors') }}</li>
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
                        <h3 class="box-title">{{$result['month']}} {{ trans('labels.Earning by Vendors') }} </h3>
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
                                            <th>{{ trans('labels.Vendors') }}</th>
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
                                            <td>{{ $monthlyearning['vendors'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['item_price'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['shipping_cost'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['coupon_amount'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['total_amount'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['admin_commision'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['vendor_balance'] }}</td>
                                            <!-- <td>
                                                <a class="btn btn-primary" style="width: 100%; margin-bottom: 5px;"
                                                    href="{{url('admin/finance/monthreport/'. $result['month'] .'/vendor/' .$monthlyearning['vendors_id'])}}">{{ trans('labels.View') }}</a>
                                            </td> -->
                                            <td>
                                                <a class="btn btn-primary" style="width: 100%; margin-bottom: 5px;"
                                                    href="{{url('admin/finance/sattlement/'. $result['month'] .'/vendor/' .$monthlyearning['vendors_id'])}}">{{ trans('labels.View') }}</a>
                                            </td>
                                           
                                        </tr>
                                        @endforeach
                                        <tr>
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
                                            <td colspan="5" style="font-size: 16px; text-align: right;"><strong>{{ trans('labels.Total Paid by customer') }}</strong></td>
                                            <td style="font-size: 16px;"><strong>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['online_orders'] }} ({{ trans('labels.Online') }})</strong></td>
                                            <td style="font-size: 16px;"><strong>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['cod_orders'] }}  ({{ trans('labels.COD') }})</strong></td>
                                            <td style="font-size: 16px;"><strong>{{ $result['setting'][19]->value }}{{ $result['earningsbymonth']['total_prices_data']['total_order_amount'] }}</strong></td>
                                        </tr>
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