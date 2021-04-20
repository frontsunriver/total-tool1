
<section class="product-page product-page-one ">
    <div class="container">

      <div class="product-main">

          <div class="row">
            <div class="col-12 col-sm-12">
                <div class="row justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">

                          <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>

                          @if(!empty($result['category_name']) and !empty($result['sub_category_name']))
                            <li class="breadcrumb-item"><a href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('/shop?category='.$result['sub_category_slug'])}}">{{$result['sub_category_name']}}</a></li>
                          @elseif(!empty($result['category_name']) and empty($result['sub_category_name']))
                            <li class="breadcrumb-item"><a href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
                          @endif
                          <li class="breadcrumb-item active">{{$result['detail']['product_data'][0]->products_name}}</li>
                        </ol>
                      </nav>
                </div>
            </div>
            <div class="col-12 col-sm-12">
              <div class="row">
                    <div class="col-12 col-lg-5">

                      <div class="slider-wrapper">
                          <div class="slider-for">
                            <a class="slider-for__item ex1 fancybox-button" href="{{asset('').$result['detail']['product_data'][0]->image_path }}" data-fancybox-group="fancybox-button" title="@lang('website.modal_text_1')">
                              <img src="{{asset('').$result['detail']['product_data'][0]->image_path }}" alt="Zoom Image" />
                            </a>
                            @foreach( $result['detail']['product_data'][0]->images as $key=>$images )
                              @if($images->image_type == 'ACTUAL')
                              <a class="slider-for__item ex1 fancybox-button" href="{{asset('').$images->image_path }}" data-fancybox-group="fancybox-button" title="@lang('website.modal_text_1')">
                                <img src="{{asset('').$images->image_path }}" alt="Zoom Image" />
                              </a>
                              @endif
                            @endforeach

                          </div>
                          <div class="slider-nav">
                            <div class="slider-nav__item">
                              <img src="{{asset('').$result['detail']['product_data'][0]->image_path }}" alt="Zoom Image"/>
                            </div>

                            @foreach( $result['detail']['product_data'][0]->images as $key=>$images )
                            @if($images->image_type == 'THUMBNAIL')
                            <div class="slider-nav__item">
                              <img src="{{asset('').$images->image_path }}" alt="Zoom Image"/>
                            </div>
                            @endif
                            @endforeach

                          </div>
                        </div>
                  </div>

                    <div class="col-12 col-lg-7" >

                        <h1>{{$result['detail']['product_data'][0]->products_name}}</h1>
                        <div class="list-main">
                            <div class="icon-liked">
                              <a class="icon active is_liked" products_id="<?=$result['detail']['product_data'][0]->products_id?>">
                                <i class="fas fa-heart"></i>
                                <span  class="badge badge-secondary counter"  >{{$result['detail']['product_data'][0]->products_liked}}</span>
                              </a>
                              </div>
                            <ul class="list">
                              @if(!empty($result['category_name']) and !empty($result['sub_category_name']))
                                <li>{{$result['sub_category_name']}}</li>
                              @elseif(!empty($result['category_name']) and empty($result['sub_category_name']))
                                <li>{{$result['category_name']}}</li>
                              @endif
                                <li> {{$result['detail']['product_data'][0]->products_ordered}}&nbsp;@lang('website.Order(s)')</li>
                                @if($result['detail']['product_data'][0]->products_type == 0)
                                @if($result['commonContent']['settings']['Inventory'])
                                  @if($result['detail']['product_data'][0]->defaultStock < 0)
                                    <li class="outstock"><i class="fas fa-check"></i>@lang('website.Out of Stock')</li>
                                  @else
                                    <li class="instock"><i class="fas fa-check"></i>@lang('website.In stock')</li>
                                  @endif
                                @endif
                                @endif
                            </ul>
                        </div>
                        <form name="attributes" id="add-Product-form" method="post" >
                            <input type="hidden" name="products_id" value="{{$result['detail']['product_data'][0]->products_id}}">

                            <input type="hidden" name="products_price" id="products_price" value="@if(!empty($result['detail']['product_data'][0]->flash_price)) {{$result['detail']['product_data'][0]->flash_price+0}} @elseif(!empty($result['detail']['product_data'][0]->discount_price)){{$result['detail']['product_data'][0]->discount_price+0}}@else{{$result['detail']['product_data'][0]->products_price+0}}@endif">

                            <input type="hidden" name="checkout" id="checkout_url" value="@if(!empty(app('request')->input('checkout'))) {{ app('request')->input('checkout') }} @else false @endif" >

                            <input type="hidden" id="max_order" value="@if(!empty($result['detail']['product_data'][0]->products_max_stock)) {{ $result['detail']['product_data'][0]->products_max_stock }} @else 0 @endif" >
                             @if(!empty($result['cart']))
                              <input type="hidden"  name="customers_basket_id" value="{{$result['cart'][0]->customers_basket_id}}" >
                             @endif
                                <div class="product-controls row">
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
                                  <div class="col-12 col-md-4 box">
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
                                    @endforeach
                                  @endif

                                    <div class="col-12 col-md-4 box Qty" @if(!empty($result['detail']['product_data'][0]->flash_start_date) and $result['detail']['product_data'][0]->server_time < $result['detail']['product_data'][0]->flash_start_date ) style="display: none" @endif>
                                      <label>Quantity</label>
                                      <div class="Qty">
                                        <div class="input-group">
                                            <span class="input-group-btn first qtyminus">
                                              <button class="btn btn-defualt" type="button">-</button>
                                            </span>
                                            <input style="width:-20px;" type="text" readonly name="quantity" value=" @if(!empty($result['cart'])) {{$result['cart'][0]->customers_basket_quantity}} @else @if($result['detail']['product_data'][0]->products_min_order>0 and $result['detail']['product_data'][0]->defaultStock > $result['detail']['product_data'][0]->products_min_order) {{$result['detail']['product_data'][0]->products_min_order}} @else 1 @endif @endif" min="@if($result['detail']['product_data'][0]->products_min_order>0 and $result['detail']['product_data'][0]->defaultStock > $result['detail']['product_data'][0]->products_min_order) {{$result['detail']['product_data'][0]->products_min_order}} @else 1 @endif" max="@if(!empty($result['detail']['product_data'][0]->products_max_stock) and $result['detail']['product_data'][0]->products_max_stock>0 and $result['detail']['product_data'][0]->defaultStock > $result['detail']['product_data'][0]->products_max_stock){{ $result['detail']['product_data'][0]->products_max_stock}}@else{{ $result['detail']['product_data'][0]->defaultStock}}@endif" class="form-control qty">
                                            <span class="input-group-btn last qtyplus">
                                              <button class="btn btn-defualt" type="button">+</button>
                                            </span>
                                        </div>
                                      </div>
                                    </div>

                                </div>




                        <div class="product-buttons">
                            <h2>@lang('website.Total Price'):
                              <span class="total_price">

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
                                {{Session::get('symbol_left')}}{{$flash_price+0}}{{Session::get('symbol_right')}}
                                @elseif(!empty($result['detail']['product_data'][0]->discount_price))
                                {{Session::get('symbol_left')}}{{$discount_price+0}}{{Session::get('symbol_right')}}
                                @else
                                {{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}
                                @endif
                                </h2>
                              @if($result['detail']['product_data'][0]->products_min_order>0)
                                <p>
                                  @if($result['detail']['product_data'][0]->products_type == 0)
                                   <span id="min_max_setting">&nbsp; @lang('website.Min Order Limit:')</span>
                                  @elseif($result['detail']['product_data'][0]->products_type == 1)
                                   <span id="min_max_setting"></span>
                                  @endif
                                </p>
                              @endif

                              <div class="buttons">
                               @if(!empty($result['detail']['product_data'][0]->flash_start_date) and $result['detail']['product_data'][0]->server_time < $result['detail']['product_data'][0]->flash_start_date )
                                @else
                                 @if($result['detail']['product_data'][0]->products_type == 0)
                                      @if($result['commonContent']['settings']['Inventory'])
                                          @if($result['detail']['product_data'][0]->defaultStock < 0)
                                            <button class="btn  btn-block  btn-danger " type="button">@lang('website.Out of Stock')</button>
                                          @else
                                              <button class="btn btn-block btn-secondary add-to-Cart" type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                                          @endif
                                      @else
                                        <button class="btn btn-block btn-secondary add-to-Cart" type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                                      @endif
                                  @else
                                       <button class="btn btn-secondary btn-block  add-to-Cart stock-cart"  type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                                       @if($result['commonContent']['settings']['Inventory'])
                                       <button class="btn btn-danger btn-block  stock-out-cart" hidden type="button">@lang('website.Out of Stock')</button>
                                       @endif
                                  @endif
                                @endif
                              </div>

                        </div>
                      </form>

                      <div class="pro-dsc-module">
                        <div class="tab-list">
                            <div class="nav nav-pills" role="tablist">
                              <a class="nav-link nav-item nav-index active show" href="#description" id="description-tab" data-toggle="pill" role="tab">Description</a>
                              <a class="nav-link nav-item nav-index" href="#review" id="review-tab" data-toggle="pill" role="tab" >Reviews</a>
                              <a class="nav-link nav-item nav-index" href="#rate" id="rate-tab" data-toggle="pill" role="tab" >Rate</a>

                            </div>
                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane fade active show" id="description" aria-labelledby="description-tab">
                                <div class="tabs-pera">
                                    <p>
                                     <?=stripslashes($result['detail']['product_data'][0]->products_description)?>
                                    </p>

                                </div>

                              </div>
                              <div role="tabpanel" class="tab-pane fade" id="review" aria-labelledby="review-tab">

                                  <div class="tabs-pera">
                                    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

                                    <div class="container">
                                    	<h2 class="text-center">What Our Customers Feel About This Product!</h2>


                                    	  <div class="card" style="margin-bottom:10px;">
                                    	    <div class="card-body">
                                            <div class="row">
                                              <div class="col-sm-4" style="display: flex;flex-direction: column;    justify-content: center;    align-items: flex-end;">
                                                <p style="font-size: 51px;font-weight: 700;color: black;margin-bottom: -10px;">{{$result['detail']['product_data'][0]->rating}}</p>
                                                <div style="float:left;">
                                                <?php for($i=0; $i<$result['detail']['product_data'][0]->rating; $i++){ ?>
                                                <span style="margin:1px;"class="float-right"><i class="text-warning fa fa-star"></i></span>

                                                 <?php }?>
                                               </div>
                                               </div>
                                              <div class="col-sm-8">
                                                         <div class="row rating-desc" >

                                                                <div class="col-xs-8 col-md-12" style="display: flex;justify-content: start;">
                                                                    <div class="progress progress-striped">
                                                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                                                            aria-valuemin="0" aria-valuemax="100" style="width: {{$result['detail']['product_data'][0]->five_ratio}}%">
                                                                            <span class="sr-only">80%</span><p style="margin-left:4px; margin-top:19px;">5</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 5 -->

                                                                <div class="col-xs-8 col-md-12" style="display: flex;justify-content: start;">
                                                                    <div class="progress">
                                                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
                                                                            aria-valuemin="0" aria-valuemax="100" style="width: {{$result['detail']['product_data'][0]->four_ratio}}%">
                                                                            <span class="sr-only">60%</span><p style="margin-left:4px; margin-top:19px;">4</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 4 -->

                                                              <div class="col-xs-8 col-md-12" style="display: flex;justify-content: start;">
                                                                    <div class="progress">
                                                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                                                            aria-valuemin="0" aria-valuemax="100" style="width: {{$result['detail']['product_data'][0]->three_ratio}}%">
                                                                            <span class="sr-only">40%</span><p style="margin-left:4px; margin-top:19px;">3</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 3 -->

                                                              <div class="col-xs-8 col-md-12" style="display: flex;justify-content: start;">
                                                                    <div class="progress">
                                                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20"
                                                                            aria-valuemin="0" aria-valuemax="100" style="width: {{$result['detail']['product_data'][0]->two_ratio}}%">
                                                                            <span class="sr-only">20%</span><p style="margin-left:4px; margin-top:19px;">2</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 2 -->

                                                                <div class="col-xs-8 col-md-12" style="display: flex;justify-content: start;">
                                                                    <div class="progress">
                                                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                                                            aria-valuemin="0" aria-valuemax="100" style="width: {{$result['detail']['product_data'][0]->one_ratio}}%">
                                                                            <span class="sr-only">15%</span><p style="margin-left:4px; margin-top:19px;">1</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end 1 -->
                                                          </div>
                                              </div>
                                              <div class="col-md-2">
                                              </div>
                                            </div>
                                            @if(isset($result['detail']['product_data'][0]->reviewed_customers))
                                             @foreach($result['detail']['product_data'][0]->reviewed_customers as $key=>$rev)
                                    	        <div class="row">
                                            	    <div class="col-md-12">
                                                    <div class="row">


                                                          <div class="col-sm-12">
                                                            <div class="review-single @if($key%2 == 0) even @endif">
                                                              <h3>{{$rev->customers_name}}</h3>
                                                              <div class="rating-stars">
                                                                <?php for($i=0; $i<$rev->reviews_rating; $i++){ ?>
                                                               <span ><i class="text-warning fa fa-star"></i></span>

                                                                 <?php }?>
                                                                </div>
                                                              <p>
                                                                {{$rev->reviews_text}}
                                                              </p>

                                                              <span class="text-dark">{{Carbon\Carbon::now()->subDays(date("d", strtotime($rev->created_at)))->diffForHumans()}}</span>
                                                            </div>
                                                          </div>

                                                        </div>



                                            	    </div>

                                    	        </div>
                                              @endforeach
                                             @endif
                                    	    </div>
                                    	</div>

                                    </div>
                                  </div>
                              </div>
                              <div role="tabpanel" class="tab-pane fade" id="rate" aria-labelledby="rate-tab">
                              <form id="idForm">
                                   {{csrf_field()}}
                                    <div class="tabs-pera">
                                      <div class="container">
                                        <div class="feedback">
                                          <div class="rating">
                                            <input value="{{$result['detail']['product_data'][0]->products_id}}" type="hidden" name="products_id">
                                            <input required value="5" type="radio" name="rating" id="rating-5">
                                            <label for="rating-5"></label>
                                            <input required value="4" type="radio" name="rating" id="rating-4">
                                            <label for="rating-4"></label>
                                            <input required value="3" type="radio" name="rating" id="rating-3">
                                            <label for="rating-3"></label>
                                            <input required value="2" type="radio" name="rating" id="rating-2">
                                            <label for="rating-2"></label>
                                            <input required value="1" type="radio" name="rating" id="rating-1">
                                            <label for="rating-1"></label>
                                            <div class="emoji-wrapper">
                                              <div class="emoji">
                                                <svg class="rating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                                <path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534"/>
                                                <ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff"/>
                                                <ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347"/>
                                                <ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63"/>
                                                <ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff"/>
                                                <ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347"/>
                                                <ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63"/>
                                                <path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347"/>
                                              </svg>
                                                <svg class="rating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                                <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                                                <path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347"/>
                                                <path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534"/>
                                                <path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff"/>
                                                <path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347"/>
                                                <path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff"/>
                                                <path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534"/>
                                                <path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff"/>
                                                <path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347"/>
                                                <path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff"/>
                                              </svg>
                                                <svg class="rating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                                <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                                                <path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347"/>
                                                <path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff"/>
                                                <circle cx="340" cy="260.4" r="36.2" fill="#3e4347"/>
                                                <g fill="#fff">
                                                  <ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10"/>
                                                  <path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z"/>
                                                </g>
                                                <circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347"/>
                                                <ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff"/>
                                              </svg>
                                                <svg class="rating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                          <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                          <path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347"/>
                                          <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                                          <g fill="#fff">
                                            <path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z"/>
                                            <ellipse cx="356.4" cy="205.3" rx="81.1" ry="81"/>
                                          </g>
                                          <ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
                                          <g fill="#fff">
                                            <ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1"/>
                                            <ellipse cx="155.6" cy="205.3" rx="81.1" ry="81"/>
                                          </g>
                                          <ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
                                          <ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff"/>
                                            </svg>
                                                    <svg class="rating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                                    <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                                                    <path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
                                                    <path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f"/>
                                                    <path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
                                                    <path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
                                                    <path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f"/>
                                                    <path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
                                                    <path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347"/>
                                                    <path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b"/>
                                                  </svg>
                                                    <svg class="rating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <g fill="#ffd93b">
                                                      <circle cx="256" cy="256" r="256"/>
                                                      <path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z"/>
                                                    </g>
                                                    <path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4"/>
                                                    <path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea"/>
                                                    <path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88"/>
                                                    <g fill="#38c0dc">
                                                      <path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z"/>
                                                    </g>
                                                    <g fill="#d23f77">
                                                      <path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z"/>
                                                    </g>
                                                    <path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347"/>
                                                    <path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b"/>
                                                    <path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2"/>
                                                  </svg>
                                                  </div>
                                                </div>
                                              </div>
                                        </div>
                                        <div class="form-group" style="width:100%; padding:0;">
                                            <label for="exampleFormControlTextarea1">Please Write Your Reviews About This Product!</label>
                                            <textarea required name="comments" value="{{session::get('comments')}}" class="form-control" rows="3"></textarea>
                                          </div>
                                          @if(Auth::guard('customer')->check())
                                          <button class="btn btn-block btn-secondary" id="review_button" type="submit" >Here We GO!</button>
                                          @else
                                          <button class="btn btn-block btn-secondary" disabled >Login To Comment!</button>
                                          @endif
                                      </div>
                                   </div>
                                </form>

                               </div>
                             </div>
                        </div>
                      </div>

            </div>

          </div>

          </div>
      </div>

      <div class="products-area">
          <div class="row">
              <div class="col-12">
                <div class="heading">
                  <h2>
                    @lang('website.Related Products')
                  </h2>
                  <hr style="margin-bottom: 0;">
                </div>
                <div id="p2" class="owl-carousel" style="margin-bottom: 10px;">
                  @foreach($result['simliar_products']['product_data'] as $key=>$products)
                  @if($result['detail']['product_data'][0]->products_id != $products->products_id)
                  @if(++$key<=5)
                  @include('web.common.product')
                  @endif
                  @endif
                  @endforeach
                </div>
              </div>
            </div>

      </div>
    </div>
  </section>
