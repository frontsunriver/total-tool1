<div class="row ">
  <div class="col-12 col-md-6">
    <div class="row ">
      <div id="quickViewCarousel" class="carousel slide" data-ride="carousel">
          <!-- The slideshow -->
            <div class="carousel-inner">
              <div class="carousel-item active">                
                <img class="img-fluid" src="{{asset('').$result['detail']['product_data'][0]->image_path }}" alt="image">
              </div>

              @foreach( $result['detail']['product_data'][0]->images as $key=>$images )
                @if($images->image_type == 'ACTUAL')

                <div class="carousel-item">                    
                  <img class="img-fluid" src="{{asset('').$images->image_path }}" alt="image">
                </div>

                @endif
              @endforeach

            </div>
            <!-- Left and right controls -->
            <a class="carousel-control-prev btn-secondary swipe-to-top" href="#quickViewCarousel" data-slide="prev">
                <span class="fas fa-angle-left "></span>
            </a>
            <a class="carousel-control-next btn-secondary swipe-to-top" href="#quickViewCarousel" data-slide="next">
                <span class="fas fa-angle-right "></span>
            </a>
          
        </div>
    </div>

  </div>

    <div class="col-12 col-lg-6">
   
      <div class="pro-description">
        <div class="badges">
          <?php 
              $current_date = date("Y-m-d", strtotime("now"));

              $string = substr($result['detail']['product_data'][0]->products_date_added, 0, strpos($result['detail']['product_data'][0]->products_date_added, ' '));
              $date=date_create($string);
              date_add($date,date_interval_create_from_date_string($web_setting[20]->value." days"));

              $after_date = date_format($date,"Y-m-d");

              if($after_date>=$current_date){
                print '<span class="badge badge-info">';
                print __('website.New');
                print '</span>';
              }
            ?>

          @if($result['detail']['product_data'][0]->is_feature == 1)
          <span class="badge badge-success">@lang('website.Featured')</span>     
          @endif
          
          <?php
          $discount_percentage = 0;
          if(!empty($result['detail']['product_data'][0]->discount_price)){
            $discount_price = $result['detail']['product_data'][0]->discount_price * session('currency_value');
          }
          $orignal_price = $result['detail']['product_data'][0]->products_price * session('currency_value');

          if(!empty($result['detail']['product_data'][0]->discount_price)){

          if(($orignal_price+0)>0){
            $discounted_price = $orignal_price-$discount_price;
            $discount_percentage = $discounted_price/$orignal_price*100;
          }else{
            $discount_percentage = 0;
            $discounted_price = 0;
          }
          
          ?>             
          
          <?php }
          
          ?>
          @if($discount_percentage>0)
          <span class="badge badge-danger"><?php echo (int)$discount_percentage; ?>%</span>
          @endif
        </div>
          <h3 class="pro-title">{{$result['detail']['product_data'][0]->products_name}}</h3>
    
    <div class="pro-price">                     
      <?php

      if(!empty($result['detail']['product_data'][0]->discount_price)){
        $discount_price = $result['detail']['product_data'][0]->discount_price * session('currency_value');
      }
      if(!empty($result['detail']['product_data'][0]->flash_price)){
        $flash_price = $result['detail']['product_data'][0]->flash_price * session('currency_value');
      }
      $orignal_price = $result['detail']['product_data'][0]->products_price * session('currency_value');
      
       if(!empty($result['detail']['product_data'][0]->discount_price)){

        if(($orignal_price+0)>0){
        $discounted_price = $orignal_price-$discount_price;
        $discount_percentage = $discounted_price/$orignal_price*100;
        $discounted_price = $result['detail']['product_data'][0]->discount_price;

       }else{
         $discount_percentage = 0;
         $discounted_price = 0;
       }
      }
      else{
        $discounted_price = $orignal_price;
      }
      ?>
      @if(!empty($result['detail']['product_data'][0]->flash_price))
      <ins> {{Session::get('symbol_left')}}{{$flash_price+0}}{{Session::get('symbol_right')}}</ins>
      <del>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</del>
      @elseif(!empty($result['detail']['product_data'][0]->discount_price))
      <ins>{{Session::get('symbol_left')}}{{$discount_price+0}}{{Session::get('symbol_right')}}</ins>
      <del>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</del>
      @else
      <ins>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</ins>
      @endif
      </h2>
                         
      </div>

    <div class="pro-infos">
        <div class="pro-single-info"><b>@lang('website.Product ID') :</b>{{$result['detail']['product_data'][0]->products_id}}</div>
        <div class="pro-single-info pro-catgory"><b>@lang('website.Categroy')  :</b>
          @foreach($result['detail']['product_data'][0]->categories as $key=>$category)
          <a href="{{url('shop?category='.$category->categories_slug)}}">{{$category->categories_name}}</a>  &nbsp;&nbsp;
          @endforeach

          </div>     

        <div class="pro-single-info"><b>@lang('website.Available') :</b>

          @if($result['detail']['product_data'][0]->products_type == 0)
            @if($result['detail']['product_data'][0]->defaultStock == 0)
            <span class="text-secondary">@lang('website.Out of Stock')</span>
            @else
            <span class="text-secondary">@lang('website.In stock')</span>
            @endif
          @endif
        </div>

        @if($result['detail']['product_data'][0]->products_min_order>0)
              @if($result['detail']['product_data'][0]->products_type == 0)
            <div class="pro-single-info" id="min_max_setting"><b>@lang('website.Min Order Limit:') </b><a href="#">{{$result['detail']['product_data'][0]->products_min_order}}</a></div>
              @elseif($result['detail']['product_data'][0]->products_type == 1)
                <div class="pro-single-info" id="min_max_setting"></div>
              @endif
          @endif
    </div>

    <div class="popup-detail-info">
      <p>
      <?php 
        $descriptions = strip_tags($result['detail']['product_data'][0]->products_description);
        echo stripslashes($descriptions);
      ?>
      </p>
    </div>

    <form name="attributes" id="add-Product-form" method="post" >
      <input type="hidden" name="products_id" value="{{$result['detail']['product_data'][0]->products_id}}">

      <input type="hidden" name="products_price" id="products_price" value="@if(!empty($result['detail']['product_data'][0]->flash_price)) {{$result['detail']['product_data'][0]->flash_price+0}} @elseif(!empty($result['detail']['product_data'][0]->discount_price)){{$result['detail']['product_data'][0]->discount_price+0}}@else{{$result['detail']['product_data'][0]->products_price+0}}@endif">

      <input type="hidden" name="checkout" id="checkout_url" value="@if(!empty(app('request')->input('checkout'))) {{ app('request')->input('checkout') }} @else false @endif" >

      <input type="hidden" id="max_order" value="@if(!empty($result['detail']['product_data'][0]->products_max_stock)) {{ $result['detail']['product_data'][0]->products_max_stock }} @else 0 @endif" >
       @if(!empty($result['cart']))
        <input type="hidden"  name="customers_basket_id" value="{{$result['cart'][0]->customers_basket_id}}" >
       @endif


    @if(count($result['detail']['product_data'][0]->attributes)>0)
    <?php
        $index = 0;
    ?>
      @foreach( $result['detail']['product_data'][0]->attributes as $key=>$attributes_data )
      <?php
          $functionValue = 'function_'.$key++;
      ?>
      <input type="hidden" name="option_name[]" value="{{ $attributes_data['option']['name'] }}" >
      <input type="hidden" name="option_id[]" value="{{ $attributes_data['option']['id'] }}" >
      <input type="hidden" name="{{ $functionValue }}" id="{{ $functionValue }}" value="0" >
      <input id="attributeid_<?=$index?>" type="hidden" value="">
      <input id="attribute_sign_<?=$index?>" type="hidden" value="">
      <input id="attributeids_<?=$index?>" type="hidden" name="attributeid[]" value="" >
      <div class="pro-options">
            <div class="box mb-3">
              <label>{{ $attributes_data['option']['name'] }}</label>
              <div class="select-control ">
              <select name="{{ $attributes_data['option']['id'] }}" onChange="getQuantity()" class="currentstock form-control attributeid_<?=$index++?>" attributeid = "{{ $attributes_data['option']['id'] }}">
                @if(!empty($result['cart']))
                  @php
                   $value_ids = array();
                    foreach($result['cart'][0]->attributes as $values){
                        $value_ids[] = $values->options_values_id;
                    }
                  @endphp
                    @foreach($attributes_data['values'] as $values_data)
                     @if(!empty($result['cart']))
                     <option @if(in_array($values_data['id'],$value_ids)) selected @endif attributes_value="{{ $values_data['products_attributes_id'] }}" value="{{ $values_data['id'] }}" prefix = '{{ $values_data['price_prefix'] }}'  value_price ="{{ $values_data['price']+0 }}" >{{ $values_data['value'] }}</option>
                     @endif
                    @endforeach
                  @else
                    @foreach($attributes_data['values'] as $values_data)
                     <option attributes_value="{{ $values_data['products_attributes_id'] }}" value="{{ $values_data['id'] }}" prefix = '{{ $values_data['price_prefix'] }}'  value_price ="{{ $values_data['price']+0 }}" >{{ $values_data['value'] }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>                  
      </div>
      @endforeach
    @endif
  

  
    
    <div class="pro-counter" @if(!empty($result['detail']['product_data'][0]->flash_start_date) and $result['detail']['product_data'][0]->server_time < $result['detail']['product_data'][0]->flash_start_date ) style="display: none" @endif>
        <div class="input-group item-quantity">                    
            {{-- <input type="text" id="quantity1" name="quantity" class="form-control" value="10">                       --}}
            <input type="text" readonly name="quantity" class="form-control qty" 
            value="@if(!empty($result['cart'])) {{$result['cart'][0]->customers_basket_quantity}} 
            @else @if($result['detail']['product_data'][0]->products_min_order>0 and $result['detail']['product_data'][0]->defaultStock > $result['detail']['product_data'][0]->products_min_order) {{$result['detail']['product_data'][0]->products_min_order}} 
            @else {{ $result['detail']['product_data'][0]->products_min_order }} @endif @endif" 
            
            min="@if($result['detail']['product_data'][0]->products_min_order>0 and $result['detail']['product_data'][0]->defaultStock > $result['detail']['product_data'][0]->products_min_order)
             {{$result['detail']['product_data'][0]->products_min_order}} 
             @else {{ $result['detail']['product_data'][0]->products_min_order }}  @endif" 
            
            max="@if(!empty($result['detail']['product_data'][0]->products_max_stock) and $result['detail']['product_data'][0]->products_max_stock>0 and $result['detail']['product_data'][0]->defaultStock > $result['detail']['product_data'][0]->products_max_stock){{ $result['detail']['product_data'][0]->products_max_stock}}@else{{ $result['detail']['product_data'][0]->defaultStock}}@endif">              
            
            <span class="input-group-btn">
                <button type="button" class="quantity-plus1 btn qtyplus">
                    <i class="fas fa-plus"></i>
                </button>
            
                <button type="button" class="quantity-minus1 btn qtyminus">
                    <i class="fas fa-minus"></i>
                </button>
            </span>
          </div>
          @if(!empty($result['detail']['product_data'][0]->flash_start_date) and $result['detail']['product_data'][0]->server_time < $result['detail']['product_data'][0]->flash_start_date )
            @else
              @if($result['detail']['product_data'][0]->products_type == 0)

                    @if($result['commonContent']['settings']['Inventory'])
                      @if($result['detail']['product_data'][0]->defaultStock <= 0)
                      <button class="btn btn-lg swipe-to-top  btn-danger " type="button">@lang('website.Out of Stock')</button>
                      @else
                          <button class="btn btn-secondary btn-lg swipe-to-top add-to-Cart"  type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                      @endif
                  @else
                      <button class="btn btn-secondary btn-lg swipe-to-top add-to-Cart"  type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                  @endif
              @else
                    <button class="btn btn-secondary btn-lg swipe-to-top  add-to-Cart stock-cart" hidden type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                    <button class="btn btn-danger btn btn-lg swipe-to-top  stock-out-cart" hidden type="button">@lang('website.Out of Stock')</button>
              @endif
            @endif
            @if($result['detail']['product_data'][0]->products_type == 2)
            <a href="{{$result['detail']['product_data'][0]->products_url}}" target="_blank" class="btn btn-secondary btn-lg swipe-to-top">@lang('website.External Link')</a>
          @endif
  
    </div>

    
  </form>

  
    
    </div>     

  </div>

</div>


<script>
@if(!empty($result['detail']['product_data'][0]->products_type) and $result['detail']['product_data'][0]->products_type==1)
  getQuantity();
  cartPrice();
@endif
</script>
