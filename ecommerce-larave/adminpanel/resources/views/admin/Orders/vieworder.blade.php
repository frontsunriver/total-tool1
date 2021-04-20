@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.ViewOrder') }} <small> {{ trans('labels.ViewOrder') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/orders/display')}}"><i class="fa fa-dashboard"></i>  {{ trans('labels.ListingAllOrders') }}</a></li>
      <li class="active"> {{ trans('labels.ViewOrder') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="invoice" style="margin: 15px;">
      <!-- title row -->
      @if(session()->has('message'))
       <div class="col-xs-12">
       <div class="row">
      	<div class="alert alert-success alert-dismissible">
           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
           <h4><i class="icon fa fa-check"></i> {{ trans('labels.Successlabel') }}</h4>
            {{ session()->get('message') }}
        </div>
        </div>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="col-xs-12">
      	<div class="row">
        	<div class="alert alert-warning alert-dismissible">
               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
               <h4><i class="icon fa fa-warning"></i> {{ trans('labels.WarningLabel') }}</h4>
                {{ session()->get('error') }}
            </div>
          </div>
         </div>
        @endif
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header" style="padding-bottom: 25px; margin-top:0;">
            <i class="fa fa-globe"></i> {{ trans('labels.OrderID') }}# {{ $data['orders_data'][0]->orders_id }}  
            
            <small style="display: inline-block" class="label label-primary">
            @if($data['orders_data'][0]->ordered_source == 1)
            {{ trans('labels.Website') }}
            @else
            {{ trans('labels.Application') }}
            @endif
            </small>
            <small style="display: inline-block">{{ trans('labels.OrderedDate') }}: {{ date('m/d/Y', strtotime($data['orders_data'][0]->date_purchased)) }}</small>
            <a href="{{ URL::to('admin/orders/invoiceprint/'.$data['orders_data'][0]->orders_id)}}" target="_blank"  class="btn btn-default pull-right"><i class="fa fa-print"></i> {{ trans('labels.Print') }}</a>
            @if($result['commonContent']['setting']['is_enable_location']==1 and $data['orders_data'][0]->orders_status_id == 7 )
              @if($data['current_boy'])
              <button type="button" data-toggle="modal" data-target="#trackmodal" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-location-arrow"></i> {{ trans('labels.Track Order') }}</button>
              

              <!-- Modal -->
              <div id="trackmodal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-body" id="googleMap" style="height: 400px">
                    </div>
                  </div>

                </div>
              </div>
              
              @endif
            @endif
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          {{ trans('labels.CustomerInfo') }}:
          <address>
            <strong>{{ $data['orders_data'][0]->customers_name }}</strong><br>
            {{ $data['orders_data'][0]->customers_street_address }} <br>
            {{ $data['orders_data'][0]->customers_city }}, {{ $data['orders_data'][0]->customers_state }} {{ $data['orders_data'][0]->customers_postcode }}, {{ $data['orders_data'][0]->customers_country }}<br>
            {{ trans('labels.Phone') }}: {{ $data['orders_data'][0]->customers_telephone }}<br>
            {{ trans('labels.Email') }}: {{ $data['orders_data'][0]->email }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          {{ trans('labels.ShippingInfo') }}
          <address>
            <strong>{{ $data['orders_data'][0]->delivery_name }}</strong><br>
            {{ $data['orders_data'][0]->delivery_street_address }} <br>
            {{ $data['orders_data'][0]->delivery_city }}, {{ $data['orders_data'][0]->delivery_state }} {{ $data['orders_data'][0]->delivery_postcode }}, {{ $data['orders_data'][0]->delivery_country }}<br>

            <strong>{{ trans('labels.Phone') }}: </strong>{{ $data['orders_data'][0]->delivery_phone }}<br>
           <strong> {{ trans('labels.ShippingMethod') }}:</strong> {{ $data['orders_data'][0]->shipping_method }} <br>
           <strong> {{ trans('labels.ShippingCost') }}:</strong> 
           @if(!empty($data['orders_data'][0]->shipping_cost)) 
           @if(!empty($result['commonContent']['currency']->symbol_left) && $result['commonContent']['currency']->symbol_left == $data['orders_data'][0]->currency)  {{ $data['orders_data'][0]->currency }}  {{$data['orders_data'][0]->shipping_cost  * $data['orders_data'][0]->currency_value }} @else  {{$data['orders_data'][0]->shipping_cost  * $data['orders_data'][0]->currency_value }}  {{ $data['orders_data'][0]->currency }} @endif<br>
            @else --- @endif <br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
         {{ trans('labels.BillingInfo') }}
          <address>
            <strong>{{ $data['orders_data'][0]->billing_name }}</strong><br>
            {{ $data['orders_data'][0]->billing_street_address }} <br>
            <strong>{{ trans('labels.Phone') }}: </strong>{{ $data['orders_data'][0]->billing_phone }}<br>
            {{ $data['orders_data'][0]->billing_city }}, {{ $data['orders_data'][0]->billing_state }} {{ $data['orders_data'][0]->billing_postcode }}, {{ $data['orders_data'][0]->billing_country }}<br>
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>{{ trans('labels.Qty') }}</th>
              <th>{{ trans('labels.Image') }}</th>
              <th>{{ trans('labels.ProductName') }}</th>
              <th>{{ trans('labels.ProductModal') }}</th>
              <th>{{ trans('labels.Options') }}</th>
              <th>{{ trans('labels.Price') }}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($data['orders_data'][0]->data as $products)

            <tr>
                <td>{{  $products->products_quantity }}</td>
                <td >
                   <img src="{{ asset('').$products->image }}" width="60px"> <br>
                </td>
                <td  width="30%">
                    {{  $products->products_name }}<br>
                </td>
                <td>
                    {{  $products->products_model }}
                </td>
                <td>
                @foreach($products->attribute as $attributes)
                	<b>{{ trans('labels.Name') }}:</b> {{ $attributes->products_options }}<br>
                    <b>{{ trans('labels.Value') }}:</b> {{ $attributes->products_options_values }}<br>
                    <b>{{ trans('labels.Price') }}:</b> 
                    @if(!empty($result['commonContent']['currency']->symbol_left) && $result['commonContent']['currency']->symbol_left == $data['orders_data'][0]->currency)  {{ $data['orders_data'][0]->currency }}  {{ $attributes->options_values_price * $data['orders_data'][0]->currency_value }} @else  {{ $attributes->options_values_price * $data['orders_data'][0]->currency_value }}  {{ $data['orders_data'][0]->currency }} @endif<br />

                @endforeach</td>

                <td>
                  
                @if(!empty($result['commonContent']['currency']->symbol_left) && $result['commonContent']['currency']->symbol_left == $data['orders_data'][0]->currency)  {{ $data['orders_data'][0]->currency }}  {{$products->final_price  * $data['orders_data'][0]->currency_value }} @else  {{$products->final_price  * $data['orders_data'][0]->currency_value }}  {{ $data['orders_data'][0]->currency }} @endif<br>
                  </td>
             </tr>
            @endforeach

            </tbody>
          </table>
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-7">
          <p class="lead" style="margin-bottom:10px">{{ trans('labels.PaymentMethods') }}:</p>
          <p class="text-muted well well-sm no-shadow" style="text-transform:capitalize">
           	{{ str_replace('_',' ', $data['orders_data'][0]->payment_method) }}
          </p>
          @if(!empty($data['orders_data'][0]->coupon_code))
              <p class="lead" style="margin-bottom:10px">{{ trans('labels.Coupons') }}:</p>
                <table class="text-muted well well-sm no-shadow stripe-border table table-striped" style="text-align: center; ">
                	<tr>
                        <th style="text-align: center; ">{{ trans('labels.Code') }}</th>
                        <th style="text-align: center; ">{{ trans('labels.Amount') }}</th>
                    </tr>
                	@foreach( json_decode($data['orders_data'][0]->coupon_code) as $couponData)
                    	<tr>
                        	<td>{{ $couponData->code}}</td>
                            <td>{{ $couponData->amount}}

                                @if($couponData->discount_type=='percent_product')
                                    ({{ trans('labels.Percent') }})
                                @elseif($couponData->discount_type=='percent')
                                    ({{ trans('labels.Percent') }})
                                @elseif($couponData->discount_type=='fixed_cart')
                                    ({{ trans('labels.Fixed') }})
                                @elseif($couponData->discount_type=='fixed_product')
                                    ({{ trans('labels.Fixed') }})
                                @endif
                            </td>
                        </tr>
                    @endforeach
				</table>
               <!-- {{ $data['orders_data'][0]->coupon_code }}-->

          @endif
          <!-- <img src="../../dist/img/credit/visa.png" alt="Visa">
          <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../../dist/img/credit/american-express.png" alt="American Express">
          <img src="../../dist/img/credit/paypal2.png" alt="Paypal">-->

		  <p class="lead" style="margin-bottom:10px">{{ trans('labels.Orderinformation') }}:</p>
          <p class="text-muted well well-sm no-shadow" style="text-transform:capitalize; word-break:break-all;">
           @if(trim($data['orders_data'][0]->order_information) != '[]' or !empty($data['orders_data'][0]->order_information))
           		{{ $data['orders_data'][0]->order_information }}
           @endif
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-5">
          <!--<p class="lead"></p>-->

          <div class="table-responsive ">
            <table class="table order-table">
              <tr>
                <th style="width:50%">{{ trans('labels.Subtotal') }}:</th>
                <td>
                @if(!empty($result['commonContent']['currency']->symbol_left) && $result['commonContent']['currency']->symbol_left == $data['orders_data'][0]->currency)  {{ $data['orders_data'][0]->currency }}  {{$data['subtotal']  * $data['orders_data'][0]->currency_value }} @else  {{$data['subtotal']  * $data['orders_data'][0]->currency_value }}  {{ $data['orders_data'][0]->currency }} @endif<br>

                  </td>
              </tr>
              <tr>
                <th>{{ trans('labels.Tax') }}:</th>
                <td>
                @if(!empty($result['commonContent']['currency']->symbol_left) && $result['commonContent']['currency']->symbol_left == $data['orders_data'][0]->currency)  {{ $data['orders_data'][0]->currency }}  {{$data['orders_data'][0]->total_tax   * $data['orders_data'][0]->currency_value }} @else  {{$data['orders_data'][0]->total_tax   * $data['orders_data'][0]->currency_value }}  {{ $data['orders_data'][0]->currency }} @endif<br>

                  </td>
              </tr>
              <tr>
                <th>{{ trans('labels.ShippingCost') }}:</th>
                <td>
                @if(!empty($result['commonContent']['currency']->symbol_left) && $result['commonContent']['currency']->symbol_left == $data['orders_data'][0]->currency)  {{ $data['orders_data'][0]->currency }}  {{$data['orders_data'][0]->shipping_cost  * $data['orders_data'][0]->currency_value }} @else  {{$data['orders_data'][0]->shipping_cost  * $data['orders_data'][0]->currency_value }}  {{ $data['orders_data'][0]->currency }} @endif<br>
                  </td>
              </tr>
              @if(!empty($data['orders_data'][0]->coupon_code))
              <tr>
                <th>{{ trans('labels.DicountCoupon') }}:</th>
                <td>
                @if(!empty($result['commonContent']['currency']->symbol_left) && $result['commonContent']['currency']->symbol_left == $data['orders_data'][0]->currency)  {{ $data['orders_data'][0]->currency }}  {{$data['orders_data'][0]->coupon_amount  * $data['orders_data'][0]->currency_value }} @else  {{$data['orders_data'][0]->coupon_amount  * $data['orders_data'][0]->currency_value }}  {{ $data['orders_data'][0]->currency }} @endif<br>                  
              </tr>
              @endif
              <tr>
                <th>{{ trans('labels.Total') }}:</th>
                <td>
                @if(!empty($result['commonContent']['currency']->symbol_left) && $result['commonContent']['currency']->symbol_left == $data['orders_data'][0]->currency)  {{ $data['orders_data'][0]->currency }}  {{$data['orders_data'][0]->order_price  * $data['orders_data'][0]->currency_value }} @else  {{$data['orders_data'][0]->order_price  * $data['orders_data'][0]->currency_value }}  {{ $data['orders_data'][0]->currency }} @endif<br>

                  </td>
              </tr>
            </table>
          </div>

        </div>
    {!! Form::open(array('url' =>'admin/orders/updateOrder', 'method'=>'post', 'onSubmit'=>'return cancelOrder();', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
     {!! Form::hidden('orders_id', $data['orders_data'][0]->orders_id, array('class'=>'form-control', 'id'=>'orders_id'))!!}
     {!! Form::hidden('old_orders_status', $data['orders_data'][0]->orders_status_id, array('class'=>'form-control', 'id'=>'old_orders_status'))!!}
     {!! Form::hidden('customers_id', $data['orders_data'][0]->customers_id, array('class'=>'form-control', 'id'=>'device_id')) !!}
        <div class="col-xs-6">
        <hr>
          <p class="lead">{{ trans('labels.ChangeStatus') }}:</p>

            <div class="col-md-12">
              <div class="form-group">
                <label>{{ trans('labels.PaymentStatus') }}:</label>
                <select class="form-control select2" id="status_id" name="orders_status" style="width: 100%;">
                  @foreach ($data['orders_status'] as $orders_status)
                  <option value="{{ $orders_status->orders_status_id }}"
                    @if( $data['orders_data'][0]->orders_status_id == $orders_status->orders_status_id) selected="selected" @endif>
                    {{ $orders_status->orders_status_name }}
                  </option>
                  @endforeach
                {{-- @if($data['orders_data'][0]->orders_status_id == '3')
                    <option value="3" >cancel</option>
                  
                  @elseif($data['orders_data'][0]->orders_status_id == '4')
                    <option value="4" >Return</option>

                  @elseif($data['orders_data'][0]->orders_status_id == '1')
                    
                      @foreach( $data['orders_status'] as $orders_status)
                        @if($orders_status->orders_status_id  != '4')
                          <option value="{{ $orders_status->orders_status_id }}" @if( $data['orders_data'][0]->orders_status_id == $orders_status->orders_status_id) selected="selected" @endif >{{ $orders_status->orders_status_name }}</option>
                        @endif
                      @endforeach
                   

                  @elseif($data['orders_data'][0]->orders_status_id == '2')
                      @foreach( $data['orders_status'] as $orders_status)
                        @if( $orders_status->orders_status_id != '1' && $orders_status->orders_status_id != '3'  )
                          <option value="{{ $orders_status->orders_status_id }}" @if( $data['orders_data'][0]->orders_status_id == $orders_status->orders_status_id) selected="selected" @endif >{{ $orders_status->orders_status_name }}</option>
                        @endif 
                      @endforeach
                 @endif --}}
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseStatus') }}</span>
              </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                <label>{{ trans('labels.Comments') }}:</label>
                {!! Form::textarea('comments',  '', array('class'=>'form-control', 'id'=>'comments', 'rows'=>'4'))!!}
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CommentsOrderText') }}</span>
              </div>
            </div>
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> {{ trans('labels.Submit') }} </button>
             

        </div>
         <!-- this row will not appear when printing -->
            
          {!! Form::close() !!}


          {!! Form::close() !!}
                {{-- @if(trim($data['orders_data'][0]->payment_method) =='Cash on Delivery') --}}
                {!! Form::open(array('url' =>'admin/orders/assignorders', 'method'=>'post', 'class' =>
                'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                {!! Form::hidden('orders_id', $data['orders_data'][0]->orders_id, array('class'=>'form-control',
                'id'=>'orders_ids'))!!}

                @if($data['current_boy'])
                {!! Form::hidden('old_deliveryboy_id', $data['current_boy']->deliveryboy_id,
                array('class'=>'form-control', 'id'=>'deliveryboy_id')) !!}
                {!! Form::hidden('is_new', 'false', array('id'=>'is_new'))!!}
                {!! Form::hidden('orders_to_deliveryboy_id', $data['current_boy']->orders_to_deliveryboy_id,
                array('id'=>'orders_to_deliveryboy_id'))!!}
                @else
                {!! Form::hidden('is_new', 'true', array('id'=>'is_new'))!!}
                @endif

                <div class="col-xs-6">
                    <hr>
                    @if( $data['orders_data'][0]->orders_status_id == 2 or $data['orders_data'][0]->orders_status_id ==
                    6)
                    <p class="lead">{{ trans('labels.Delivery By') }}:
                        <strong>
                            @foreach( $data['delivery_boys'] as $delivery_boy)
                            @if(!empty($data['current_boy']))
                            @if($data['current_boy']->deliveryboy_id == $delivery_boy->id)
                            {{ $delivery_boy->first_name }} {{ $delivery_boy->last_name }}
                            ({{ $delivery_boy->deliveryboy_status }})
                            @endif
                            @endif
                            @endforeach
                            </stroing>
                    </p>
                    @else
                    
                    @if($result['commonContent']['setting']['is_deliverboy_purchased'] == '1')
                    <p class="lead">{{ trans('labels.Assign Order to Delivery Boy') }}:</p>
                    <div class="col-md-12">
                        <div class="form-group">

                            <label>{{ trans('labels.Choose Delivery Boy') }}:</label>
                            <select class="form-control" id="is_new_boy" required name="deliveryboy_id">
                                <option value="">{{ trans('labels.Choose Delivery Boy') }}</option>
                                @foreach( $data['delivery_boys'] as $delivery_boy)
                                <option value="{{ $delivery_boy->id }}" @if(!empty($data['current_boy'])) @if(
                                    $data['current_boy']->deliveryboy_id == $delivery_boy->id) selected="selected"
                                    @endif @endif>
                                    {{ $delivery_boy->first_name }} {{ $delivery_boy->last_name }}
                                    ({{ $delivery_boy->deliveryboy_status }})
                                </option>
                                @endforeach
                            </select>
                            <span class="help-block"
                                style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Choose Delivery Boy') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i>
                      {{ trans('labels.Submit') }} </button>
                    @endif  
                    @endif


                </div>
                <!-- this row will not appear when printing -->
                {{-- @endif --}}
                {!! Form::close() !!}

        <div class="col-xs-12">
          <p class="lead">{{ trans('labels.OrderHistory') }}</p>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>{{ trans('labels.Date') }}</th>
                  <th>{{ trans('labels.Status') }}</th>
                  <th>{{ trans('labels.Comments') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $data['orders_status_history'] as $orders_status_history)
                    <tr>
                        <td>
							<?php
								$date = new DateTime($orders_status_history->date_added);
								$status_date = $date->format('d-m-Y');
								print $status_date;
							?>
                        </td>
                        <td>
                        	@if($orders_status_history->orders_status_id==1)
                            	<span class="label label-warning">
                            @elseif($orders_status_history->orders_status_id==2)
                                <span class="label label-success">
                            @elseif($orders_status_history->orders_status_id==3)
                                 <span class="label label-danger">
                            @else
                                 <span class="label label-primary">
                            @endif
                            {{ $orders_status_history->orders_status_name }}
                                 </span>
                        </td>
                        <td style="text-transform: initial;">{{ $orders_status_history->comments }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


    </section>
  <!-- /.content -->
</div>
@if($result['commonContent']['setting']['is_enable_location']==1 and $result['commonContent']['setting']['google_map_api'] != '')
<script src="https://www.gstatic.com/firebasejs/5.3.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.3.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.3.0/firebase-database.js"></script>
    <script>
/**
 * Firebase config block.
 */
var config = {
    apiKey: "{{$result['commonContent']['setting']['google_map_api']}}",
    authDomain: "{{$result['commonContent']['setting']['auth_domain']}}",
    databaseURL: "{{$result['commonContent']['setting']['database_URL']}}",
    projectId: "{{$result['commonContent']['setting']['projectId']}}",
    storageBucket: "{{$result['commonContent']['setting']['storage_bucket']}}",
    messagingSenderId: "{{$result['commonContent']['setting']['messaging_senderid']}}",
    appId: "{{$result['commonContent']['setting']['firebase_appid']}}"
};
  
  firebase.initializeApp(config);

/**
 * Data object to be written to Firebase.
 */
var data = {sender: 456456, timestamp: null, lat: null, lng: null};

function makeInfoBox(controlDiv, map) {
  // Set CSS for the control border.
  var controlUI = document.createElement('div');
  controlUI.style.boxShadow = 'rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px';
  controlUI.style.backgroundColor = '#fff';
  controlUI.style.border = '2px solid #fff';
  controlUI.style.borderRadius = '2px';
  controlUI.style.marginBottom = '22px';
  controlUI.style.marginTop = '10px';
  controlUI.style.textAlign = 'center';
  controlDiv.appendChild(controlUI);

  // Set CSS for the control interior.
  var controlText = document.createElement('div');
  controlText.style.color = 'rgb(25,25,25)';
  controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
  controlText.style.fontSize = '100%';
  controlText.style.padding = '6px';
  controlText.textContent =
      'The map shows all clicks made in the last 10 minutes.';
  controlUI.appendChild(controlText);
}

      /**
      * Starting point for running the program. Authenticates the user.
      * @param {function()} onAuthSuccess - Called when authentication succeeds.
      */
      function initAuthentication(onAuthSuccess) {
        firebase.auth().signInAnonymously().catch(function(error) {
          console.log(error.code + ', ' + error.message);
        }, {remember: 'sessionOnly'});

        firebase.auth().onAuthStateChanged(function(user) {
          if (user) {
            data.sender = user.uid;
            onAuthSuccess();
          } else {
            // User is signed out.
          }
        });
      }

      /**
       * Creates a map object with a click listener and a heatmap.
       */
      function initMap() {
        var map = new google.maps.Map(document.getElementById('googleMap'), {
          center: {lat: 0, lng: 0},
          zoom: 3,
          styles: [{
            featureType: 'poi',
            stylers: [{ visibility: 'off' }]  // Turn off POI.
          },
          {
            featureType: 'transit.station',
            stylers: [{ visibility: 'off' }]  // Turn off bus, train stations etc.
          }],
          disableDoubleClickZoom: true,
          streetViewControl: false,
        });

        // Create the DIV to hold the control and call the makeInfoBox() constructor
        // passing in this DIV.
        var infoBoxDiv = document.createElement('div');
        makeInfoBox(infoBoxDiv, map);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(infoBoxDiv);

        // Listen for clicks and add the location of the click to firebase.
        map.addListener('click', function(e) {
          data.lat = e.latLng.lat();
          data.lng = e.latLng.lng();
          addToFirebase(data);
        });

        // Create a heatmap.
        var heatmap = new google.maps.visualization.HeatmapLayer({
          data: [],
          map: map,
          radius: 16
        });

        initAuthentication(initFirebase.bind(undefined, heatmap));
      }

      /**
       * Set up a Firebase with deletion on clicks older than expiryMs
       * @param {!google.maps.visualization.HeatmapLayer} heatmap The heatmap to
       */
      function initFirebase(heatmap) {

        // 10 minutes before current time.
        var startTime = new Date().getTime() - (60 * 10 * 1000);

        // Reference to the clicks in Firebase.
        var clicks = firebase.database().ref('clicks');

        // Listen for clicks and add them to the heatmap.
        clicks.orderByChild('timestamp').startAt(startTime).on('child_added',
          function(snapshot) {
            // Get that click from firebase.
            var newPosition = snapshot.val();
            var point = new google.maps.LatLng(newPosition.lat, newPosition.lng);
            var elapsedMs = Date.now() - newPosition.timestamp;

            // Add the point to the heatmap.
            heatmap.getData().push(point);

            // Request entries older than expiry time (10 minutes).
            var expiryMs = Math.max(60 * 10 * 1000 - elapsedMs, 0);

            // Set client timeout to remove the point after a certain time.
            window.setTimeout(function() {
              // Delete the old point from the database.
              snapshot.ref.remove();
            }, expiryMs);
          }
        );

        // Remove old data from the heatmap when a point is removed from firebase.
        clicks.on('child_removed', function(snapshot, prevChildKey) {
          var heatmapData = heatmap.getData();
          var i = 0;
          while (snapshot.val().lat != heatmapData.getAt(i).lat()
            || snapshot.val().lng != heatmapData.getAt(i).lng()) {
            i++;
          }
          heatmapData.removeAt(i);
        });
      }

      /**
       * Updates the last_message/ path with the current timestamp.
       * @param {function(Date)} addClick After the last message timestamp has been updated,
       *     this function is called with the current timestamp to add the
       *     click to the firebase.
       */
      function getTimestamp(addClick) {
        // Reference to location for saving the last click time.
        var ref = firebase.database().ref('last_message/' + data.sender);

        ref.onDisconnect().remove();  // Delete reference from firebase on disconnect.

        // Set value to timestamp.
        ref.set(firebase.database.ServerValue.TIMESTAMP, function(err) {
          if (err) {  // Write to last message was unsuccessful.
            console.log(err);
          } else {  // Write to last message was successful.
            ref.once('value', function(snap) {
              addClick(snap.val());  // Add click with same timestamp.
            }, function(err) {
              console.warn(err);
            });
          }
        });
      }

      /**
       * Adds a click to firebase.
       * @param {Object} data The data to be added to firebase.
       *     It contains the lat, lng, sender and timestamp.
       */
      function addToFirebase(data) {
        getTimestamp(function(timestamp) {
          // Add the new timestamp to the record data.
          data.timestamp = timestamp;
          var ref = firebase.database().ref('clicks').push(data, function(err) {
            if (err) {  // Data was not written to firebase.
              console.warn(err);
            }
          });
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?=$result['commonContent']['setting']['google_map_api']?>&libraries=visualization&callback=initMap">
    </script>
    @endif

@endsection
