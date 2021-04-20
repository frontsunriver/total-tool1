@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Finance {{ trans('labels.Finance') }} <small>Finance {{ trans('labels.Finance') }} ...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/deliveryboys/display')}}"><i class="fa fa-dashboard"></i>
                    {{ trans('labels.Delivery Boys') }}</a></li>
            <li class="active">Finance {{ trans('labels.Finance') }} </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->        

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Finance {{ trans('labels.Finance') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">

                        <!-- /.row -->
                    <div class="row">
                    
                    <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{asset($result['deliveryboy']->avatar)}}" alt="{{ $result['deliveryboy']->first_name }} profile picture">
                        <h3 class="profile-username text-center">{{ $result['deliveryboy']->first_name }} {{ $result['deliveryboy']->last_name }}</h3>
                        <!-- <p class="text-muted text-center">
                            <span class="label label-success"> asdsad</span>                       
                        </p>
                        <p class="text-muted text-center">    
                        @if(count($result['rating'])>0)                                           
                            @for($i=1; $i<=5; $i++)
                                @if($result['rating']->reviews_rating>=$i)
                                    <span class="fa fa-star checked"></span>                                                
                                @else
                                    <span class="fa fa-star"></span>   
                                @endif    
                            @endfor
                        @else
                            @for($i=1; $i<=5; $i++)
                                <span class="fa fa-star"></span>
                            @endfor
                        @endif    
                        
                        </p> -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    </div>

                    <div class="col-xs-12 col-md-3">
                        <div class="panel panel-default panel-sale text-center">
                            <div class="panel-heading">{{ trans('labels.Today') }}</div>
                            <div class="panel-body">
                                <div class="count"> 
                                    <span id="total_sales_span">
                                    {{$result['commonContent']['currency']->symbol_left}}{{$result['todayearnings']}}{{$result['commonContent']['currency']->symbol_right}}
                                        
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-3">
                        <div class="panel panel-default panel-sale text-center">
                            <div class="panel-heading">{{ trans('labels.7 Days') }}</div>
                            <div class="panel-body">
                                <div class="count"> 
                                    <span id="total_sales_span">
                                        {{$result['commonContent']['currency']->symbol_left}}{{$result['earningsbyweek']['total_amount']}}{{$result['commonContent']['currency']->symbol_right}}
                                    </span>
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
                                    {{$result['commonContent']['currency']->symbol_left}}{{$result['earningsbymonth']}}{{$result['commonContent']['currency']->symbol_right}}
                                    
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                            <div class="col-xs-12 label label-primary">
                                <div class="panel-heading" style="text-align:left;font-size: 20px;">
                                    {{ trans('labels.Last 7 Days') }}   
                                    <!-- <a  href="{{url('admin/finance/monthreport/'. $result['month'] .'/deliveryboy/' .$result['deliveryboy']->id)}}" class="pull-right" style="color:#fff; margin-right: 6px;">{{ trans('labels.View all') }}</a> -->
                                </div>                                
                            </div>  
                        <div class="row">
                            <div class="col-xs-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('labels.Date') }}</th>
                                            <th>{{ trans('labels.COD') }}</th>
                                            <th>{{ trans('labels.With Card') }}</th>
                                            <th>{{ trans('labels.Total') }}</th>
                                            <!-- <th>{{ trans('labels.Action') }}</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(count($result['earningsbyweek']['sale_data'])>0)
                                        @foreach ($result['earningsbyweek']['sale_data'] as $key=>$monthlyearning)
                                        <tr>
                                            <td>{{ $monthlyearning->date_purchased }}</td>
                                            <td>
                                                @if($monthlyearning->payment_method == 'Cash on Delivery')
                                                {{$result['commonContent']['currency']->symbol_left}}{{ $monthlyearning->shipping_cost }}{{$result['commonContent']['currency']->symbol_right}}
                                                @else
                                                {{$result['commonContent']['currency']->symbol_left}}0{{$result['commonContent']['currency']->symbol_right}}
                                                @endif                                            
                                            </td>
                                            <td>
                                                @if($monthlyearning->payment_method != 'Cash on Delivery')
                                                {{$result['commonContent']['currency']->symbol_left}}{{ $monthlyearning->shipping_cost }}{{$result['commonContent']['currency']->symbol_right}}
                                                @else
                                                {{$result['commonContent']['currency']->symbol_left}}0{{$result['commonContent']['currency']->symbol_right}}
                                                @endif                                            
                                            </td>
                                            <td>{{ $monthlyearning->shipping_cost}}</td>
                                            
                                        </tr>
                                        @endforeach
                                        
                                        @else
                                        <tr>
                                            <td colspan="7"><strong>{{ trans('labels.NoRecordFound') }}</strong></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-xs-12 label label-primary">
                            <div class="panel-heading" style="text-align:left;font-size: 20px;">
                                {{ trans('labels.All Sattlements') }}                                   
                            </div>                                
                        </div>  

                        <div class="row">
                            <div class="col-xs-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('labels.Date') }} </th>
                                            <th>{{ trans('labels.COD / Card') }}</th>
                                            <th>{{ trans('labels.Total Amount') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>

                                        <tbody id="customers-table">
                                            @if (isset($result['withdraw']))
                                            @foreach ($result['withdraw'] as $key=>$vendor)
                                            
                                            <tr>
                                                <td>                                               
                                                    {{ date('d/m/Y',strtotime($vendor->created_at)) }}
                                                </td>
                                                <td>
                                                @if($vendor->payment_method == 'Cash on Delivery')
                                                {{$result['commonContent']['currency']->symbol_left}}{{ $vendor->amount }}{{$result['commonContent']['currency']->symbol_right}}
                                                @else
                                                {{$result['commonContent']['currency']->symbol_left}}0{{$result['commonContent']['currency']->symbol_right}}
                                                @endif
                                                /
                                                @if($vendor->payment_method != 'Cash on Delivery')
                                                {{$result['commonContent']['currency']->symbol_left}}{{ $vendor->amount }}{{$result['commonContent']['currency']->symbol_right}}
                                                @else
                                                {{$result['commonContent']['currency']->symbol_left}}0{{$result['commonContent']['currency']->symbol_right}}
                                                @endif</td>
                                                <td>
                                                    {{$result['commonContent']['currency']->symbol_left}}{{ $vendor->amount }}{{$result['commonContent']['currency']->symbol_right}}
                                                </td>
                                                <td>
                                                
                                                @if($vendor->status == 0)
                                                    <button class="btn btn-default deliveryboy-pay-popup" payment_id = "{{ $vendor->payment_withdraw_id }}" deliveryboy_id = "{{ $vendor->user_id }}" >{{ trans('labels.Pay') }}</button>
                                                @else
                                                    <span class="btn btn-success deliveryboy-pay-popup-paid" payment_id = "{{ $vendor->payment_withdraw_id }}" deliveryboy_id = "{{ $vendor->user_id }}">{{ trans('labels.Paid info') }}</span>
                                                @endif 
                                                <!-- <a href="{{ URL::to('admin/deliveryboys/finance/sattlement/orders?deliveryboys_id='.$vendor->user_id.'&payment_id='.$vendor->payment_withdraw_id)}}" class="btn btn-primary pay-popup" >{{ trans('labels.View') }}</a> -->
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </thead>
                                    
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="vendors-info" tabindex="-1" role="dialog" aria-labelledby="bankinfoModal">

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