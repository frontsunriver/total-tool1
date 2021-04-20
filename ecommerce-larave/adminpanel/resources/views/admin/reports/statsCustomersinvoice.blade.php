@extends('admin.layout')
<style>
.wrapper.wrapper2{
	display: block;
}
.wrapper{
	display: none;
}
</style>
<body onload="window.print();">
<div class="wrapper wrapper2">
  <!-- Main content -->
  <section class="invoice" style="margin: 15px;">
      <!-- title row -->
      
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header" style="padding-bottom: 25px">
          <div class="box-body no-padding">
              <form  name='registration' method="get" action="{{url('admin/customers-orders-report')}}">
              <input type="hidden" name="type" value="all">
              <div class="box-body">
              @if(app('request')->input('dateRange'))
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Date') }}</label>
                    <p>{{app('request')->input('dateRange')}}</p>
                  </div>
                </div>
                @endif
                @if( app('request')->input('customers_id'))
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Customers') }}</label>
                        @foreach($result['customers'] as $customers)
                         <p> @if  (app('request')->input('customers_id') == $customers->id) {{$customers->first_name}} {{$customers->last_name}} @endif </p>
                        @endforeach
                  </div>
                </div>
                @endif
                @if( app('request')->input('orders_status_id'))
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.OrdersStatus') }}</label>
                        @foreach($result['orderstatus'] as $status)
                        <p>  @if  (app('request')->input('orders_status_id') == $status->orders_status_id) {{$status->orders_status_name}} @endif</p>
                        @endforeach
                  </div>
                </div>
                @endif
                @if( app('request')->input('deliveryboys_id'))
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Choose Devlieryboy') }}</label>
                        @foreach($result['deliveryboys'] as $deliveryboy)
                        <p> @if  (app('request')->input('deliveryboys_id') == $deliveryboy->id) {{$deliveryboy->first_name}} {{$deliveryboy->last_name}} @endif </p>
                        @endforeach
                  </div>
                </div>
                @endif

                
                @if( app('request')->input('orderid'))
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.OrderID') }}</label>
                        <p> {{app('request')->input('orderid')}} </p>
                  </div>
                </div>
                @endif
      
            </div>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
        <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th>{{ trans('labels.CustomerName') }}</th>
                      <th>{{ trans('labels.Order Source') }}</th>
                      <th>{{ trans('labels.OrderTotal') }}</th>
                      <th>{{ trans('labels.DatePurchased') }}</th>
                      <th>{{ trans('labels.Status') }} </th>
                      <th>{{ trans('labels.deliveryBoy') }} </th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(count($result['reports']['orders'])>0)
                    @foreach ($result['reports']['orders'] as $key=>$orderData)
                    <tr>
                        <td>{{ $orderData->orders_id }}</td>
                        <td>{{ $orderData->customers_name }}</td>
                        <td>
                            @if($orderData->ordered_source == 1)
                            {{ trans('labels.Website') }}
                            @else
                            {{ trans('labels.Application') }}
                            @endif</td>
                        <td>

                            @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $orderData->order_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                        <td>{{ date('d/m/Y', strtotime($orderData->date_purchased)) }}</td>
                        <td>
                            @if($orderData->orders_status_id==1)
                                <span class="label label-warning">
                            @elseif($orderData->orders_status_id==2)
                                <span class="label label-success">
                            @elseif($orderData->orders_status_id==3)
                                <span class="label label-danger">
                            @else
                                <span class="label label-primary">
                            @endif
                            {{ $orderData->orders_status }}
                                </span>
                        </td>
                        <td>
                  
                            ---

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
        <!-- /.col -->

      </div>
      <!-- /.row -->

      <!-- /.row -->


    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
