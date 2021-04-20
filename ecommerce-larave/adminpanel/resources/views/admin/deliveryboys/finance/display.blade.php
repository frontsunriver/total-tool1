@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ trans('labels.Finance') }} <small>{{ trans('labels.Finance') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">{{ trans('labels.Finance') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.Finance') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="row">

                            <div class="col-xs-12 col-md-3">
                                <div class="panel panel-default panel-sale text-center">
                                    <div class="panel-heading">{{ trans('labels.Today') }}</div>
                                    <div class="panel-body">
                                        <div class="count">
                                        <span id="total_sales_span">{{ $result['setting'][19]->value }}{{ $result['todaysearnings'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-3">
                                <div class="panel panel-default panel-sale text-center">
                                    <div class="panel-heading">{{ trans('labels.7 Days') }}</div>
                                    <div class="panel-body">
                                        <div class="count">
                                            <span id="total_sales_span">{{ $result['setting'][19]->value }}{{ $result['sevendaysearnings'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col-xs-12 col-md-3">
                                <div class="panel panel-default panel-sale text-center">
                                    <div class="panel-heading">{{ trans('labels.This Month') }}</div>
                                    <div class="panel-body">
                                        <div class="count">
                                                                                    
                                            <span id="total_sales_span">
                                            @if(count($result['monthlyearnings'])>0)
                                                @foreach ($result['monthlyearnings'] as $key=>$monthlyearning)
                                                    @if($monthlyearning['currentmonth'])
                                                    {{ $result['setting'][19]->value }}{{ $monthlyearning['currentmonth'] }}
                                                    @endif
                                                @endforeach
                                            @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-3">
                                <div class="panel panel-default panel-sale text-center">
                                    <div class="panel-heading">{{ trans('labels.Last Month') }}</div>
                                    <div class="panel-body">
                                        <div class="count">
                                            <span id="total_sales_span">
                                            @if(count($result['monthlyearnings'])>0)
                                                @foreach ($result['monthlyearnings'] as $key=>$monthlyearning)
                                                    @if($monthlyearning['lastmonth'])
                                                    {{ $result['setting'][19]->value }}{{ $monthlyearning['lastmonth'] }}
                                                    @endif
                                                @endforeach
                                            @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                </br>
                                <div class="box-header">
                                    <h3 class="box-title">{{ trans('labels.Earning by Month') }} </h3>
                                </div></br>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('labels.Month') }}</th>
                                            <th>{{ trans('labels.ProductsPrice') }}</th>
                                            <th>{{ trans('labels.ShippingCost') }}</th>
                                            <th>{{ trans('labels.CouponAmount') }}</th>
                                            <th>{{ trans('labels.Total Amount') }}</th>
                                            <th>{{ trans('labels.Admin Commission') }}</th>
                                            <th>{{ trans('labels.Vendor Earning') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(count($result['monthlyearnings'])>0)
                                        @foreach ($result['monthlyearnings'] as $key=>$monthlyearning)
                                        <tr>
                                            <td>{{ $monthlyearning['month'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['item_price'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['shipping_cost'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['coupon_amount'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['total_amount'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['admin_commision'] }}</td>
                                            <td>{{ $result['setting'][19]->value }}{{ $monthlyearning['vendor_balance'] }}</td>
                                            <td>
                                                <a class="btn btn-primary" style="width: 100%; margin-bottom: 5px;"
                                                    href="{{url('admin/finance/month')}}/{{ $monthlyearning['month'] }}">{{ trans('labels.View') }}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6"><strong>{{ trans('labels.NoRecordFound') }}</strong></td>
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