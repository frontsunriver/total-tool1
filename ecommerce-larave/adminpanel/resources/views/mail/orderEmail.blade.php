
<div style="padding: 5px;">
  <div style="width: 100%; display: block">
    <h2 style="font-size: 20px;border-bottom: 1px solid #eee;padding-bottom: 20px;">{{ trans('labels.OrderID') }}# {{ $ordersData['orders_data'][0]->orders_id }} <span style="
    background-color: #3c8dbc;
    display: inline;
    padding: .2em .6em .3em;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
    font-size:14px !important;
    position: relative;
    top: -2px;
    margin: 0 5px;
    display: none;
    "> Pending</span> <small style="font-size: 14px;float: right;padding-right: 12px;margin-top: 6px;">{{ trans('labels.OrderedDate') }}: {{ date('m/d/Y', strtotime($ordersData['orders_data'][0]->date_purchased)) }}</small> </h2>
  </div>
  
  <!-- info row -->
  <div style="display: display: block;width: 100%;padding: 0 0 20px;">
    <div style="display: inline-block; width:32%"> <strong>{{ trans('labels.CustomerInfo') }}:</strong>
      <address>
      <span style="text-transform: capitalize;">{{ $ordersData['orders_data'][0]->customers_name }}</span><br>
      {{ $ordersData['orders_data'][0]->customers_street_address }} <br>
        {{ $ordersData['orders_data'][0]->customers_city }}, {{ $ordersData['orders_data'][0]->customers_state }} {{ $ordersData['orders_data'][0]->customers_postcode }}, {{ $ordersData['orders_data'][0]->customers_country }}<br>
        {{ trans('labels.Phone') }}: {{ $ordersData['orders_data'][0]->customers_telephone }}<br>
        {{ trans('labels.Email') }}: {{ $ordersData['orders_data'][0]->email }}
      </address>
    </div>
    <div style="display: inline-block; width:32%"> <strong>{{ trans('labels.ShippingInfo') }}:</strong>
      <address>
      <span style="text-transform: capitalize;">{{ $ordersData['orders_data'][0]->delivery_name }}</span><br>
      {{ $ordersData['orders_data'][0]->delivery_street_address }} <br>
      {{ $ordersData['orders_data'][0]->delivery_city }}, {{ $ordersData['orders_data'][0]->delivery_state }} {{ $ordersData['orders_data'][0]->delivery_postcode }}, {{ $ordersData['orders_data'][0]->delivery_country }}
      </address>
    </div>
    <div style="display: inline-block; width:32%"> <strong>{{ trans('labels.BillingInfo') }}:</strong>
      <address>
      <span style="text-transform: capitalize;">{{ $ordersData['orders_data'][0]->billing_name }}</span><br>
       {{ $ordersData['orders_data'][0]->billing_street_address }} <br>
       {{ $ordersData['orders_data'][0]->billing_city }}, {{ $ordersData['orders_data'][0]->billing_state }} {{ $ordersData['orders_data'][0]->billing_postcode }}, {{ $ordersData['orders_data'][0]->billing_country }}
      </address>
    </div>
    
    <!-- /.col --> 
  </div>
  <!-- /.row --> 
  
  <!-- Table row -->
  <table class="table table-striped" style="width: 100%;background-color: transparent;margin: 15px 0 15px;">
    <thead>
      <tr>
        <th align="center">{{ trans('labels.Qty') }}</th>
        <th align="center" >{{ trans('labels.Image') }}</th>
        <th align="center">{{ trans('labels.ProductName') }}</th>
        <th align="center">{{ trans('labels.AdditionalAttributes') }}</th>
        <th align="center">{{ trans('labels.Price') }}</th>
      </tr>
    </thead>
    <tbody style="text-transform: capitalize;font-size: 12px;">
     @foreach($ordersData['orders_data'][0]->data as $key=>$products)
      <tr @if($key%2==0) style="background-color: #f9f9f9;" @endif>
      
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif {{  $products->products_quantity }}</td>
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif<img src="{{ asset('').$products->image }}" width="60px"> </td>
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif  {{  $products->products_name }}<br></td>
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif
            @foreach($products->attribute as $attributes)
                <b>Name:</b> {{ $attributes->products_options }}<br>
                <b>Value:</b> {{ $attributes->products_options_values }}<br>
                <b>Price:</b> {{ $attributes->price_prefix }}{{ $attributes->options_values_price }}<br>
    
            @endforeach
        </td>
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif{{ $ordersData['orders_data'][0]->currency }}{{ $products->final_price }}</td>
      </tr>
      @endforeach
      
    </tbody>
  </table>
  
  <!-- /.row -->
  
  <div style="display: block;"> 
    <!-- accepted payments column -->
    <div style="float:left;width: 64%;padding-right: 4%;">
      <p class="lead" style="margin-bottom: 0;font-size: 18px;font-weight: bold;">{{ trans('labels.PaymentMethods') }}:</p>
      <p style="text-transform:capitalize; border: 1px solid #e3e3e3; padding: 10px;border-radius: 4px;background-color: #f5f5f5;margin-top: 5px;"> {{ str_replace('_',' ', $ordersData['orders_data'][0]->payment_method) }} </p>
      
      @if(!empty($ordersData['orders_data'][0]->coupon_code))
      <p style="margin-bottom: 5px;font-size: 18px;font-weight: bold;">{{ trans('labels.Coupons') }}:</p>
      <table style="text-align: center; width: 80%;
    border-radius: 3px;     margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;">
        <tr>
          <th style="text-align: center; border-top: 1px solid #f4f4f4;     padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;">{{ trans('labels.Code') }}</th>
          <th style="text-align: center; border-top: 1px solid #f4f4f4;     padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;">{{ trans('labels.Amount') }}</th>
        </tr>
    
     @foreach( json_decode($ordersData['orders_data'][0]->coupon_code) as $couponData)
        <tr>
          <td style="text-align: center; border-top: 1px solid #e3e3e3;     padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;">{{ $couponData->code}}</td>
    
          <td style="text-align: center; border-top: 1px solid #e3e3e3;     padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;">{{ $couponData->amount}} 
            
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
      
      @endif
      
    </div>
    <!-- /.col -->
    <div style=" float: right; width:30%"> 
      
        <table style="width: 100%;padding: 38px 0;">
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.Subtotal') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;">{{ $ordersData['orders_data'][0]->currency }}{{ $ordersData['subtotal'] }}</td>
          </tr>
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.Tax') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;">{{ $ordersData['orders_data'][0]->currency }}{{ $ordersData['orders_data'][0]->total_tax }}</td>
          </tr>
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.ShippingCost') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;">{{ $ordersData['orders_data'][0]->currency }}{{ $ordersData['orders_data'][0]->shipping_cost }}</td>
          </tr>
          @if(!empty($ordersData['orders_data'][0]->coupon_code))
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.DicountCoupon') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;">{{ $ordersData['orders_data'][0]->currency }}{{ $ordersData['orders_data'][0]->coupon_amount }}</td>
          </tr>
          @endif
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.Total') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;">{{ $ordersData['orders_data'][0]->currency }}{{ $ordersData['orders_data'][0]->order_price }}</td>
          </tr>
        </table>
        
    </div>
    
    <!-- /.col --> 
  </div>
  <!-- /.row --> 
  
  <!-- /.content --> 
</div>
