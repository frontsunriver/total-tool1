@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>{{ trans('labels.Customer Report') }} <small>{{ trans('labels.Customer Report') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Customer Report') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->

    <!-- /.row -->

    <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('labels.Filter') }}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body no-padding">
              <form  name='registration' method="get" action="{{url('admin/customers-orders-report')}}">
              <input type="hidden" name="type" value="all">
              <div class="box-body">
                <div class="col-xs-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Choose start and end date') }}</label>
                    <input class="form-control reservation dateRange" placeholder="{{ trans('labels.Choose start and end date') }}" readonly value="{{app('request')->input('dateRange')}}" name="dateRange" aria-label="Text input with multiple buttons ">
                  </div>
                </div>
                <div class="col-xs-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.Choose Customer') }}</label>
                    <select type="button" class="btn btn-default select2 form-control" required data-toggle="dropdown" name="customers_id" id="customers_id"  >
                        <option value="">{{trans('labels.Choose Customer')}}</option>
                        @foreach($result['customers'] as $customers)
                        <option value="{{$customers->id}}"  @if( app('request')->input('customers_id')) @if  (app('request')->input('customers_id') == $customers->id) {{ 'selected' }} @endif @endif>{{$customers->first_name}} {{$customers->last_name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <!-- <div class="col-xs-2">
                  <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('labels.currency') }}</label>
                    <select type="button" class="btn btn-default select2 form-control" data-toggle="dropdown" name="currency" id="currency">
                        @foreach($result['currency'] as $currency)
                          <option value="{{ $currency->symbol_left ? $currency->symbol_left : $currency->symbol_right }}"  @if( app('request')->input('currency')) @if  (app('request')->input('currency') == $currency->symbol_right || app('request')->input('currency') == $currency->symbol_left) {{ 'selected' }} @endif @endif>{{ $currency->symbol_left ? $currency->symbol_left : $currency->symbol_right}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>             -->
                <div class="col-xs-2" style="padding-top: 25px">                  
                  <div class="form-group">
                    <button class="btn btn-primary" id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    @if(app('request')->input('type') and app('request')->input('type') == 'all')  <a class="btn btn-danger " href="{{url('admin/customers-orders-report')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                  </div>
                </div>       
            </div>
              <!-- /.box-body -->

            </form>  
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
                <div class="col-lg-9 form-inline" id="contact-form">
                    
                    <form method="get" action="{{url('admin/customers-orders-report')}}">
                        <input type="hidden" name="type"  value="id">
                        <input type="hidden"  value="{{csrf_token()}}">
                        <div class="input-group-form search-panel ">
                            <input class="form-control" placeholder="{{ trans('labels.Please enter order ID') }}" value="{{app('request')->input('orderid')}}" name="orderid" aria-label="Text input with multiple buttons ">
                                                     
                            <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                            @if(app('request')->input('type') and app('request')->input('type') == 'id')   <a class="btn btn-danger " href="{{url('admin/customers-orders-report')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                        </div>
                    </form>

                  </div>
                  <div class="box-tools pull-right">
                    <form action="{{ URL::to('admin/customer-orders-print')}}" target="_blank">
                      <input type="hidden" name="page" value="invioce">
                      <input type="hidden" name="customers_id" value="{{app('request')->input('customers_id')}}">
                      <input type="hidden" name="orders_status_id" value="{{app('request')->input('orders_status_id')}}">
                      <input type="hidden" name="dateRange" value="{{app('request')->input('dateRange')}}">
                      <input type="hidden" name="orderid" value="{{app('request')->input('orderid')}}">
                      <button type='submit' class="btn btn-default pull-right"><i class="fa fa-print"></i> {{ trans('labels.Print') }}</button>
                    </form>
                  </div>
                </div>
                

          <!-- /.box-header -->
          <div class="box-body">

            <div class="row">
              <div class="col-xs-12">
              <?php $totalSale = 0; ?>
              <div class="box-tools pull-right">
                 <!-- <h2><small>{{trans('labels.Total Sale Price')}}:</small>@if( $result['commonContent']['currency']->symbol_left == app('request')->input('currency') ) {{ app('request')->input('currency') }} @endif {{ $result['price'] }} @if($result['commonContent']['currency']->symbol_left != app('request')->input('currency') ) {{ app('request')->input('currency') }} @endif </h2> -->
                 <h2><small>{{trans('labels.Total Sale Price')}}:</small>$ {{ $result['price'] }} </h2>
              </div>

              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th>{{ trans('labels.CustomerName') }}</th>
                      <th>{{ trans('labels.Order Source') }}</th>
                      <th>{{ trans('labels.OrderTotal') }}</th>
                      <th>{{ trans('labels.DatePurchased') }}</th>
                      <th>{{ trans('labels.Status') }} </th>
                      <th>{{ trans('labels.Action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(count($result['reports']['orders']) > 0)
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
                            @if( $result['commonContent']['currency']->symbol_left == app('request')->input('currency') ) {{ app('request')->input('currency') }} @endif {{ $orderData->order_price }} @if($result['commonContent']['currency']->symbol_left != app('request')->input('currency') ) {{ app('request')->input('currency') }} @endif</td>
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
                            <a data-toggle="tooltip" target="_blank" data-placement="bottom" title="{{ trans('labels.View Invoice') }}" href="{{url('admin/orders/invoiceprint/'.$orderData->orders_id)}}" class="badge bg-light-blue"><i class="fa fa-eye" aria-hidden="true"></i>{{ trans('labels.View Invoice') }}</a>
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

              <div class="col-xs-12" style="background: #eee;">
              @if(count($result['reports']['orders']) > 0)
                  @php
                 
                    if($result['reports']['orders']->total() > 0){
                      $fromrecord = ($result['reports']['orders']->currentpage()-1)*$result['reports']['orders']->perpage()+1;
                    }else{
                      $fromrecord = 0;
                    }
                    if($result['reports']['orders']->total() < $result['reports']['orders']->currentpage()*$result['reports']['orders']->perpage()){
                      $torecord = $result['reports']['orders']->total();
                    }else{
                      $torecord = $result['reports']['orders']->currentpage()*$result['reports']['orders']->perpage();
                    }

                  @endphp
                  <div class="col-xs-12 col-md-6" style="padding:30px 15px; border-radius:5px;">
                    <div>Showing {{$fromrecord}} to {{$torecord}}
                        of  {{$result['reports']['orders']->total()}} entries
                    </div>
                  </div>
                <div class="col-xs-12 col-md-6 text-right">
                    {{ $result['reports']['orders']->appends(\Request::except('type'))->render() }}
                </div>
              @endif
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
