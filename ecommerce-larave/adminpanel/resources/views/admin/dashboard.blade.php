@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            <small>{{ trans('labels.title_dashboard') }} {{$result['commonContent']['setting']['admin_version']}}</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</li>
            </ol>
        </section>
       
        <!-- Main content -->
        <section class="content">
            @if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->dashboard_view == 1)
            
                <div class="row">
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3>{{ $result['totalCustomers'] }}</h3>

                      <p>{{ trans('labels.customerRegistrations') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ URL::to('admin/customers/display')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllCustomers') }}">{{ trans('labels.viewAllCustomers') }}  <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3>{{ $result['totalProducts'] }}</h3>

                      <p>{{ trans('labels.totalProducts') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ URL::to('admin/products/display')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllProducts') }}">{{ trans('labels.viewAllProducts') }} <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-light-blue">
                      <div class="inner">
                      <h3>{{count($result['completed_orders'])}}</h3>
                        <p>{{ trans('labels.CompleteOrders') }}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a href="{{ URL::to('admin/orders/display')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllOrders') }}">{{ trans('labels.viewAllOrders') }} <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                <!-- ./col -->

              </div>
              <div class="row">
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{ count($result['pending_orders']) }}</h3>
        			        <p>{{ trans('labels.NewOrders') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ URL::to('admin/orders/display')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.NewOrders') }}">{{ trans('labels.NewOrders') }} <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-teal">
                    <div class="inner">
                      <h3>
                      <b>@if(count($result['total_sales_currency_wise']) > 0)
                            @foreach($result['total_sales_currency_wise'] as $key => $sales)
                                $ {{ number_format($sales->sale,2) }} 
                               
                                @if($key !== count($result['total_sales_currency_wise']))
                                    <br />
                                @endif
                            @endforeach
                      @else
                        0
                      @endif
                      </b>
                      </h3>
                        <p>{{ trans('labels.Total Money Earned') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ URL::to('admin/orders/display')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllOrders') }}">{{ trans('labels.viewAllOrders') }} <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                @if($result['commonContent']['setting']['Inventory'] == '1')
                <div class="col-lg-4 col-xs-6">

                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3>{{ $result['outOfStock'] }} </h3>
                      <p>{{ trans('labels.outOfStock') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ URL::to('admin/outofstock')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.outOfStock') }}">{{ trans('labels.outOfStock') }} <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                @endif
                <!-- ./col -->
                </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="nav-tabs-custom">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{ trans('labels.addedSaleReport') }}</h3>
                            <div class="box-tools pull-right">
                                <p class="notify-colors"><span class="sold-content" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.totalsales') }}"></span> {{ trans('labels.totalsales') }}  <span class="purchased-content" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.totalcustomers') }}"></span>{{ trans('labels.totalcustomers') }} </p>
                            </div>
                        </div>
                        {!! Form::hidden('reportBase',  $result['reportBase'] , array('id'=>'reportBase')) !!}
                        <ul class="nav nav-tabs">
                            <li class="{{ Request::is('admin/dashboard/last_year') ? 'active' : '' }}"><a href="{{ url('admin/dashboard/last_year')}}">{{ trans('labels.lastYear') }}</a></li>
                            <li class="{{ Request::is('admin/dashboard/last_month') ? 'active' : '' }}"><a href="{{ url('admin/dashboard/last_month')}}">{{ trans('labels.LastMonth') }}</a></li>
                            <li class="{{ Request::is('admin/dashboard/this_month') ? 'active' : '' }}"><a href="{{ url('admin/dashboard/this_month')}}">{{ trans('labels.thisMonth') }}</a></li>
                            <li style="width: 33%"><a href="#" data-toggle="tab">
                                    <div class="input-group ">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default" aria-label="Help">{{ trans('labels.custom') }}</button>
                                        </div>
                                        <input class="form-control reservation dateRange" readonly value="" name="dateRange" aria-label="Text input with multiple buttons ">
                                        <div class="input-group-btn"><button type="button" class="btn btn-primary getRange" >{{ trans('labels.go') }}</button> </div>
                                    </div>
                                </a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <!-- Post -->
                                <div class="chart">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="salesChart" style="height: 400px;"></canvas>
                                </div>
                                <!-- /.post -->
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <div class="col-md-12" style="display: none">
                    <div class="box">
                        <div class="box-header with-border">
                            <!--<h3 class="box-title pull-left">Monthly Report</h3>-->

                            <div class="col-xs-12 col-lg-4">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default" aria-label="Help">{{ trans('labels.customDate') }}</button>
                                    </div>
                                    <input class="form-control" aria-label="Text input with multiple buttons">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary">{{ trans('labels.go') }}</button>
                                    </div>
                                </div>
                            </div>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-center">
                                        <strong>{{ trans('labels.sales') }}: 1 Jan, 2014 - 30 Jul, 2014</strong>
                                    </p>

                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas id="salesChart" style="height: 400px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->

                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                        <div class="box-footer" style="display: none">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                                        <h5 class="description-header">$35,210.43</h5>
                                        <span class="description-text">{{ trans('labels.total_revenue') }}</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                                        <h5 class="description-header">$10,390.90</h5>
                                        <span class="description-text">{{ trans('labels.total_cost') }}</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                                        <h5 class="description-header">$24,813.53</h5>
                                        <span class="description-text">{{ trans('labels.total_profit') }}</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                                        <h5 class="description-header">1200</h5>
                                        <span class="description-text">{{ trans('labels.goal_completions') }}</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->

                    <!-- /.box -->
                    <div class="row">
                        <!-- /.col -->

                        <div class="col-md-12">
                            <!-- USERS LIST -->
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{ trans('labels.latest_customers') }}</h3>

                                    <div class="box-tools pull-right">
                                        {{--<span class="label label-danger">{{ count($result['customers']) }} {{ trans('labels.new_members') }}</span>--}}
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    @if(count($result['customers'])>0)
                                        <ul class="users-list clearfix">
                                            <?php $i = 1; ?>
                                            @foreach ($result['customers']  as $customer)
                                                    @if($i<=21)
                                                        <li>
                                                            <img src="{{asset('images/user.png')}}">
                                                            <a class="users-list-name" href="{{ url('admin/customers/edit/') }}/{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</a>
                                                            <span class="users-list-date">{{$customer->created_at}}</span>
                                                        </li>
                                                    @endif
                                                    <?php $i++; ?>
                                                {{--@endforeach--}}
                                            @endforeach
                                        </ul>
                                    @else
                                        <p style="padding: 8px 0 0 10px;">{{ trans('labels.no_customer_exist') }}</p>
                                @endif

                                <!-- /.users-list -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="{{ url('admin/customers/display')}}" class="uppercase" data-toggle="tooltip" data-placement="bottom" title="View All Customers">{{ trans('labels.viewAllCustomers') }}</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!--/.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ trans('labels.NewOrders') }}</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('labels.OrderID') }}</th>
                                        <th>{{ trans('labels.CustomerName') }}</th>
                                        <th>{{ trans('labels.TotalPrice') }}</th>
                                        <th>{{ trans('labels.Status') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($result['orders'])>0)
                                        @foreach($result['orders'] as $total_orders)
                                            @foreach($total_orders as $key=>$orders)
                                                @if($key<=10)
                                                    <tr>
                                                        <td><a href="{{ URL::to('admin/orders/vieworder/') }}/{{ $orders->orders_id }}" data-toggle="tooltip" data-placement="bottom" title="Go to detail">{{ $orders->orders_id }}</a></td>
                                                        <td>{{ $orders->customers_name }}</td>
                                                        <td>
                                                            @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ floatval($orders->total_price) }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                                                        </td>
                                                        <td>
                                                            @if($orders->orders_status_id==1)
                                                                <span class="label label-warning"></span>
                            @elseif($orders->orders_status_id==2)
                                                                  <span class="label label-success">
                            @elseif($orders->orders_status_id==3)
                                                                </span>  <span class="label label-danger"></span>
                            @else
                                                                  <span class="label label-primary">
                            @endif
                                                                                            {{ $orders->orders_status }}
                                 </span>


                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    @else
                                        <tr>
                                            <td colspan="4">{{ trans('labels.noOrderPlaced') }}</td>

                                        </tr>
                                    @endif


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <!--<a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>-->
                            <a href="{{ URL::to('admin/orders/display') }}" class="btn btn-sm btn-default btn-flat pull-right" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllOrders') }}">{{ trans('labels.viewOrders') }}</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <div class="col-md-4">

                    <!-- PRODUCT LIST -->

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ trans('labels.GoalCompletion') }}</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                       
                            <!-- /.progress-group -->
                            @if(count($result['total_orders'])>0)
                                <div class="progress-group">
                                    <span class="progress-text">{{ trans('labels.CompleteOrders') }}</span>
                                    <span class="progress-number"><b>{{ count($result['completed_orders']) }}</b>/{{ count($result['total_orders']) }}</span>
                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-green" style="width: {{ count($result['completed_orders'])*100/count($result['total_orders']) }}%"></div>
                                    </div>
                                </div>
                            @endif
                            @if(count($result['total_orders'])>0)
                            <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">{{ trans('labels.PendingOrders') }}</span>
                                    <span class="progress-number"><b>{{ count($result['pending_orders']) }}</b>/{{ count($result['total_orders']) }}</span>
                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-yellow" style="width: {{ count($result['pending_orders'])*100/count($result['total_orders']) }}%"></div>
                                    </div>
                                </div>
                            @endif
                            @if(count($result['total_orders'])>0)
                            <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">{{ trans('labels.RefundOrders') }}</span>
                                    <span class="progress-number"><b>{{ count($result['refunded_orders']) }}</b>/{{ count($result['total_orders']) }}</span>
                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-blue" style="width: {{ count($result['refunded_orders'])*100/count($result['total_orders']) }}%"></div>
                                    </div>
                                </div>
                            @endif
                            @if(count($result['total_orders'])>0)
                            <!-- /.progress-group -->
                                <div class="progress-group">
                                    <span class="progress-text">{{ trans('labels.CancelOrders') }}</span>
                                    <span class="progress-number"><b>{{ count($result['cancelled_orders']) }}</b>/{{ count($result['total_orders']) }}</span>
                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-red" style="width: {{ count($result['cancelled_orders'])*100/count($result['total_orders']) }}%"></div>
                                    </div>
                                </div>
                            @endif
                        <!-- /.progress-group -->
                            @if(count($result['total_orders'])>0)
                                <div class="progress-group">
                                    <span class="progress-text">{{ trans('labels.InprocessOrders') }}</span>
                                    <span class="progress-number"><b>{{ count($result['inprocess']) }}</b>/{{ count($result['total_orders']) }}</span>
                                    <div class="progress sm">
                                        <div class="progress-bar progress-bar-red" style="width: {{ count($result['inprocess'])*100/count($result['total_orders']) }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ trans('labels.RecentlyAddedProducts') }}</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                @foreach($result['recentProducts'] as $recentProducts)
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="{{asset('').$recentProducts->products_image}}" alt="" width=" 100px" height="100px">
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ URL::to('admin/products/edit') }}/{{ $recentProducts->products_id }}" class="product-title">{{ $recentProducts->products_name }}
                                                <span class="label label-warning label-succes pull-right">
                                                    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ floatval($recentProducts->products_price) }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                                                    </span></a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="{{ URL::to('admin/products/display') }}" class="uppercase" data-toggle="tooltip" data-placement="bottom" title="View All Products">{{ trans('labels.viewAllProducts') }}</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            @endif
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>

    <script src="{!! asset('admin/dist/js/pages/dashboard2.js') !!}"></script>
@endsection
