@if($result['flash_sale']['success']==1)
<!-- Products content -->

<section class="pro-content pro-fs-content" >
  <div class="container"> 
    <div class="products-area ">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-6">
              <div class="pro-heading-title">
                <h2> @lang('website.Flash Sale')
                </h2>
                <p> 
                  @lang('website.Flash Sale Text')
                </div>
          </div>
    
        </div>
  </div>
  </div>
  <div class="general-product">
    <div class="container  p-0">
      <div class="popular-carousel-js">
        @foreach($result['flash_sale']['product_data'] as $key=>$products)
        @if( date("Y-m-d", $products->server_time) >= date("Y-m-d", $products->flash_start_date))

        <div class="">
          <div class="product">
            <article>
                <div class="flash-p">
                    <div class="pro-description">
                        <div class="pro-info blink">
                          @lang('website.Super deal of the Month')                       
                        </div>

                        <?php

                              if(!empty($products->flash_price)){
                                  $discount_price = $products->flash_price;
                              }
                              
                              $orignal_price = $products->products_price;
                              
                              if(!empty($products->flash_price)){

                                if(($orignal_price+0)>0){
                                  $discounted_price = $orignal_price-$discount_price;
                                  $discount_percentage = $discounted_price/$orignal_price*100;
                                  $discounted_price =$products->flash_price;
                                  }else{
                                    $discount_percentage = 0;
                                    $discounted_price = 0;
                                }

                            }
                          ?>

                          <span class="tag">
                            <?php 
                            $cates2='';
                              foreach($products->categories as $key=>$category){
                                $cates2 =  trim($category->categories_name);
                              }   
                              echo $cates2;                  
                            ?>                                 
                          </span>
                          <h4 class="pro-title">
                            <span> <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}"> {{$products->products_name}} </a> </span>                           
                            
                          </h4>    
                          <div class="price">            
                            
                            @if(!empty($products->flash_price))
                            {{Session::get('symbol_left')}}{{($discounted_price+0) * session('currency_value')}}{{Session::get('symbol_right')}}
                              <span>{{Session::get('symbol_left')}}{{($orignal_price+0) * session('currency_value')}}{{Session::get('symbol_right')}}</span>
                            
                            
                            @else
                              {{Session::get('symbol_left')}}{{($orignal_price+0) *session('currency_value')}}{{Session::get('symbol_right')}}
                            @endif 

                          </div>                      
                           

                          <div class="countdown pro-timer" id="counter_{{$products->products_id}}" data-placement="bottom" title="@lang('website.Countdown Timer')" >                               
                            <span class="days">0<small>@lang('website.Days') </small></span>
                            <span class="hours">0<small>@lang('website.Hours')</small></span>
                            <span class="mintues">0<small>@lang('website.Minutes')</small></span>
                            <span class="seconds">0<small>@lang('website.Seconds')</small></span>
                          </div>

                    </div>

                    <div class="pro-thumb">                   
                      <div class="product-flash-hover">   
                          @if($products->products_type==0)
                              @if(!in_array($products->products_id,$result['cartArray']))
                                  @if($products->defaultStock==0)
                                      <button type="button" class="btn btn-block btn-danger swipe-to-top" products_id="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Out of Stock')">@lang('website.Out of Stock')</button>
                                  @elseif($products->products_min_order>1)
                                  <a class="btn btn-block btn-secondary swipe-to-top" href="{{ URL::to('/product-detail/'.$products->products_slug)}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.View Detail')">@lang('website.View Detail')</a>
                                  @else
                                      <button type="button" class="btn btn-block btn-secondary cart swipe-to-top" products_id="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Add to Cart')">@lang('website.Add to Cart')</button>
                                  @endif
                              @else
                                  <button type="button" class="btn btn-block btn-secondary active swipe-to-top" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Added')">@lang('website.Added')</button>
                              @endif
                          @elseif($products->products_type==1)
                              <a class="btn btn-block btn-secondary swipe-to-top" href="{{ URL::to('/product-detail/'.$products->products_slug)}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.View Detail')">@lang('website.View Detail')</a>
                          @elseif($products->products_type==2)
                              <a href="{{$products->products_url}}" target="_blank" class="btn btn-block btn-secondary swipe-to-top" data-toggle="tooltip" data-placement="bottom" title="@lang('website.External Link')">@lang('website.External Link')</a>
                          @endif

                      </div>           
                    <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}" alt="{{$products->products_name}}">  
                    </div>
                    
                 
                </div>
          
            </article>
              
          </div>
      </div>


        @else

        <div class="">
          <div class="product">
            <article>
                <div class="flash-p">
                    <div class="pro-description">
                        <div class="pro-info blink"> 
                            @lang('website.Comming Soon')                 
                        </div>

                        <?php

                              if(!empty($products->flash_price)){
                                  $discount_price = $products->flash_price;
                              }
                              
                              $orignal_price = $products->products_price;
                              
                              if(!empty($products->flash_price)){

                                if(($orignal_price+0)>0){
                                  $discounted_price = $orignal_price-$discount_price;
                                  $discount_percentage = $discounted_price/$orignal_price*100;
                                  $discounted_price =$products->flash_price;
                                  }else{
                                    $discount_percentage = 0;
                                    $discounted_price = 0;
                                }

                            }
                          ?>

                          <span class="tag">
                            <?php 
                            $cates2='';
                              foreach($products->categories as $key=>$category){
                                $cates2 =  trim($category->categories_name);
                              }   
                              echo $cates2;                  
                            ?>                                
                          </span>
                          <h4 class="pro-title">
                            <span>{{$products->products_name}} </span>

                            @if(!empty($products->flash_price))
                            <ins>{{Session::get('symbol_left')}}{{($discounted_price+0) * session('currency_value')}}{{Session::get('symbol_right')}}
                              <del>{{Session::get('symbol_left')}}{{($orignal_price+0) * session('currency_value')}}{{Session::get('symbol_right')}}</del>
                            </ins>
                            
                            @else
                              <ins>{{Session::get('symbol_left')}}{{($orignal_price+0) *session('currency_value')}}{{Session::get('symbol_right')}}</ins>
                            @endif 
                            
                          </h4>                         
                           

                          <div class="countdown pro-timer" data-placement="bottom" title="@lang('website.Countdown Timer')">                               
                            <span class="days">0<small>@lang('website.Days') </small></span>
                            <span class="hours">0<small>@lang('website.Hours')</small></span>
                            <span class="mintues">0<small>@lang('website.Minutes')</small></span>
                            <span class="seconds">0<small>@lang('website.Seconds')</small></span>
                          </div>

                    </div>

                    <div class="pro-thumb">                   
                      <div class="product-flash-hover">                        
                           <a class="btn btn-block btn-secondary swipe-to-top" href="{{ URL::to('/product-detail/'.$products->products_slug)}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.View Detail')">@lang('website.View Detail')</a>
                      </div>           
                    <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}" alt="{{$products->products_name}}">  
                    </div>
                    
                 
                </div>
          
            </article>
              
          </div>
      </div>

  
        @endif
            @endforeach
      

      </div>
    </div>
  </div>
</section>


@endif
<script>

jQuery(document).ready(function(e) {

   @if(!empty($result['flash_sale']['success']) and $result['flash_sale']['success']==1)
       @foreach($result['flash_sale']['product_data'] as $key=>$products)
	   @if( date("Y-m-d",$products->server_time) >= date("Y-m-d",$products->flash_start_date))
	    var product_div_{{$products->products_id}} = 'product_div_{{$products->products_id}}';
		var  counter_id_{{$products->products_id}} = 'counter_{{$products->products_id}}';
		var inputTime_{{$products->products_id}} = "{{date('M d, Y H:i:s' ,$products->flash_expires_date)}}";

		// Set the date we're counting down to
		var countDownDate_{{$products->products_id}} = new Date(inputTime_{{$products->products_id}}).getTime();

		// Update the count down every 1 second
		var x_{{$products->products_id}} = setInterval(function() {

		  // Get todays date and time
		  var now = new Date().getTime();

		  // Find the distance between now and the count down date
		  var distance_{{$products->products_id}} = countDownDate_{{$products->products_id}} - now;

		  // Time calculations for days, hours, minutes and seconds
		  var days_{{$products->products_id}} = Math.floor(distance_{{$products->products_id}} / (1000 * 60 * 60 * 24));
		  var hours_{{$products->products_id}} = Math.floor((distance_{{$products->products_id}} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		  var minutes_{{$products->products_id}} = Math.floor((distance_{{$products->products_id}} % (1000 * 60 * 60)) / (1000 * 60));
		  var seconds_{{$products->products_id}} = Math.floor((distance_{{$products->products_id}} % (1000 * 60)) / 1000);
      var days_text = "@lang('website.Days')";
		  // Display the result in the element with id="demo"
		  document.getElementById(counter_id_{{$products->products_id}}).innerHTML = "<span class='days'>"+days_{{$products->products_id}} + "<small>@lang('website.Days')</small></span> <span class='hours'>" + hours_{{$products->products_id}} + "<small>@lang('website.Hours')</small></span> <span class='mintues'> "
		  + minutes_{{$products->products_id}} + "<small>@lang('website.Minutes')</small></span> <span class='seconds'>" + seconds_{{$products->products_id}} + "<small>@lang('website.Seconds')</small></span> ";

		  // If the count down is finished, write some text
		  if (distance_{{$products->products_id}} < 0) {
			clearInterval(x_{{$products->products_id}});
			//document.getElementById(counter_id_{{$products->products_id}}).innerHTML = "EXPIRED";
			document.getElementById('product_div_{{$products->products_id}}').remove();
		  }
		}, 1000);
  	   @endif
	 @endforeach
   @endif

	@if(!empty($result['detail']['product_data'][0]->flash_start_date))
		@if( $result['detail']['product_data'][0]->server_time >= $result['detail']['product_data'][0]->flash_start_date)

			var inputTime = "{{date('M d, Y H:i:s' ,$result['detail']['product_data'][0]->flash_expires_date)}}";

			var countDownDate = new Date(inputTime).getTime();

			// Update the count down every 1 second
			var x = setInterval(function() {

			  // Get todays date and time
			  var now = new Date().getTime();

			  // Find the distance between now and the count down date
			  var distance = countDownDate - now;

			  // Time calculations for days, hours, minutes and seconds
			  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			  // Display the result in the element with id="demo"
			  document.getElementById("counter_product").innerHTML = days + "d " + hours + "h "
			  + minutes + "m " + seconds + "s ";
				document.getElementById("counter_product").style.display = 'block';
			  // If the count down is finished, write some text
			  if (distance < 0) {
				clearInterval(x);
				document.getElementById("counter_product").innerHTML = "EXPIRED";
				document.getElementById("add-to-Cart").style.display = 'none';
			  }
			}, 1000);
		@endif
	@endif
});
</script>
