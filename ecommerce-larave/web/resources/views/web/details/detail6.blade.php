<div class="container-fuild">
  <nav aria-label="breadcrumb">
      <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>

              @if(!empty($result['category_name']) and !empty($result['sub_category_name']))
                <li class="breadcrumb-item active"><a href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
                <li class="breadcrumb-item active"><a href="{{ URL::to('/shop?category='.$result['sub_category_slug'])}}">{{$result['sub_category_name']}}</a></li>
              @elseif(!empty($result['category_name']) and empty($result['sub_category_name']))
                <li class="breadcrumb-item active"><a href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
              @endif
              @if($result['detail']['product_data'])
              <li class="breadcrumb-item active">{{$result['detail']['product_data'][0]->products_name}}</li>
              @endif
          </ol>
      </div>
    </nav>
</div> 

<section class="pro-content">
@if($result['detail']['product_data'])
  <div class="container">
    <div class="page-heading-title">
        <h2> {{$result['detail']['product_data'][0]->products_name}} 
        </h2>         
    </div>
</div>


<section class="product-page">
  <div class="container"> 
    <div class="product-main">
      <div class="row">
        <div class="col-12 col-sm-12">

    <div class="row">
      <div class="col-12 col-lg-4  ">
          <div class="slider-wrapper slider-banner pd2">
            
              <div class="slider-for">

                @if(!empty($result['detail']['product_data'][0]->products_video_link))
                <a class="slider-for__item ex1 fancybox-button iframe">
                  {!! $result['detail']['product_data'][0]->products_video_link !!}                 
                </a>
                @endif
                
                <a class="slider-for__item ex1 fancybox-button" href="{{asset('').$result['detail']['product_data'][0]->default_images }}" data-fancybox-group="fancybox-button">
                  <img src="{{asset('').$result['detail']['product_data'][0]->default_images }}" alt="Zoom Image" />
                </a>
            
                @foreach( $result['detail']['product_data'][0]->images as $key=>$images )
                  @if($images->image_type == 'LARGE')

                  <a class="slider-for__item ex1 fancybox-button" href="{{asset('').$images->image_path }}" data-fancybox-group="fancybox-button" >
                    <img src="{{asset('').$images->image_path }}" alt="Zoom Image" />
                  </a>
                  
                  @elseif($images->image_type == 'ACTUAL')
                  <a class="slider-for__item ex1 fancybox-button" href="{{asset('').$images->image_path }}" data-fancybox-group="fancybox-button">
                    <img src="{{asset('').$images->image_path }}" alt="Zoom Image" />
                  </a>
                  @endif
                @endforeach
              </div>
            
              <div class="slider-nav">

                @if(!empty($result['detail']['product_data'][0]->products_video_link))
                <div class="slider-nav__item">
                  <img src="{{asset('web/images/miscellaneous/video-thumbnail.jpg')}}" alt="Zoom Image"/>
                </div>
                @endif
                
                <div class="slider-nav__item">
                  <img src="{{asset('').$result['detail']['product_data'][0]->default_thumb }}" alt="Zoom Image"/>
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
      <div class="col-12 col-lg-6 pd2">
        <div class="row">
            <div class="col-12 col-md-12">
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
              @if($result['detail']['product_data'][0]->is_feature == 1)
              <span class="badge badge-success">@lang('website.Featured')</span>     
              @endif
              
              
            </div>

                <h5 class="pro-title">{{$result['detail']['product_data'][0]->products_name}}</h5>
          
          <div class="price">                     
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
            <sub class="total_price">{{Session::get('symbol_left')}}{{$flash_price}}{{Session::get('symbol_right')}}</sub>
            <span>{{Session::get('symbol_left')}}{{$orignal_price}}{{Session::get('symbol_right')}} </span> 
            @elseif(!empty($result['detail']['product_data'][0]->discount_price))
            <price class="total_price">{{Session::get('symbol_left')}}{{$discount_price}}{{Session::get('symbol_right')}}</price>
            <span>{{Session::get('symbol_left')}}{{$orignal_price}}{{Session::get('symbol_right')}} </span> 
            @else
            <price class="total_price">{{Session::get('symbol_left')}}{{$orignal_price}}{{Session::get('symbol_right')}}</price>
            @endif
                               
            </div>

            <div class="pro-rating">
              <fieldset class="disabled-ratings">                                           
                <label class = "full fa @if($result['detail']['product_data'][0]->rating >= 5) active @endif" for="star_5" title="@lang('website.awesome_5_stars')"></label>
                <label class = "full fa @if($result['detail']['product_data'][0]->rating >= 4) active @endif" for="star_4" title="@lang('website.pretty_good_4_stars')"></label>                                          
                <label class = "full fa @if($result['detail']['product_data'][0]->rating >= 3) active @endif" for="star_3" title="@lang('website.pretty_good_3_stars')"></label>                                          
                <label class = "full fa @if($result['detail']['product_data'][0]->rating >= 2) active @endif" for="star_2" title="@lang('website.meh_2_stars')"></label>
                 <label class = "full fa @if($result['detail']['product_data'][0]->rating >= 1) active @endif" for="star1" title="@lang('website.meh_1_stars')"></label>
              </fieldset>                                          
              <a href="#review" id="review-tabs" data-toggle="pill" role="tab" class="btn-link">{{$result['detail']['product_data'][0]->total_user_rated}} @lang('website.Reviews') </a>
            </div>

          <div class="pro-infos">
              <div class="pro-single-info"><b>@lang('website.Product ID') : </b>{{$result['detail']['product_data'][0]->products_id}}</div>
              <div class="pro-single-info"><b>@lang('website.Categroy')  : </b>
                <?php
                $cates = '';  
                ?>
                @foreach($result['detail']['product_data'][0]->categories as $key=>$category)
                    
                  <?php
                    $cates =  "<a href=".url('shop?category='.$category->categories_name).">".$category->categories_name."</a>";
                  ?>  
                  
                @endforeach
                <?php 
                echo $cates;
                ?>

                </div>
              
              {{-- <div class="pro-single-info">
                <b>Tags :</b>
                <ul>
                    <li><a href="#">bracelets</a></li>
                    <li><a href="#">diamond</a></li>
                    <li><a href="#">ring</a></li>
                    
                </ul>
              </div> --}}
              
                <div class="pro-single-info"><b>@lang('website.Available') :</b>
              

                @if($result['detail']['product_data'][0]->products_type == 0)
                    @if($result['commonContent']['settings']['Inventory'])
                        @if($result['detail']['product_data'][0]->defaultStock < 0)
                        <span class="text-secondary">@lang('website.Out of Stock')</span>
                        @else
                        <span class="text-secondary">@lang('website.In stock')</span>
                        @endif
                    @else 
                      <span class="text-secondary">@lang('website.In stock')</span>    
                    @endif
                @endif

                @if($result['detail']['product_data'][0]->products_type == 1)
                <span class="text-secondary variable-stock"></span>
                @endif

                @if($result['detail']['product_data'][0]->products_type == 2)
                <span class="text-secondary">@lang('website.External')</span>
                @endif
              </div>

              <p>
              @if($result['detail']['product_data'][0]->products_min_order>0)
                  
                    
                  <div class="pro-single-info" id="min_max_setting3"><b>@lang('website.Min Order Limit') : </b>{{$result['detail']['product_data'][0]->products_min_order}}</div>
                    
                 
                @endif
                  
                <div class="pro-single-info"  @if($result['detail']['product_data'][0]->products_max_stock==9999) style="display:none;" @endif id="min_max_setting2"><b>@lang('website.Max Order Limit') : </b>{{$result['detail']['product_data'][0]->products_max_stock}}</div>
                  
                </p>
          </div>

          <form name="attributes" id="add-Product-form" method="post" >
            <input type="hidden" name="products_id" value="{{$result['detail']['product_data'][0]->products_id}}">

            <input type="hidden" name="products_price" id="products_price" value="@if(!empty($result['detail']['product_data'][0]->flash_price)) {{$result['detail']['product_data'][0]->flash_price+0}} @elseif(!empty($result['detail']['product_data'][0]->discount_price)){{$result['detail']['product_data'][0]->discount_price+0}}@else{{$result['detail']['product_data'][0]->products_price+0}}@endif">

            <input type="hidden" name="checkout" id="checkout_url" value="@if(!empty(app('request')->input('checkout'))) {{ app('request')->input('checkout') }} @else false @endif" >

            <input type="hidden" id="max_order" value="@if(!empty($result['detail']['product_data'][0]->products_max_stock)){{ $result['detail']['product_data'][0]->products_max_stock }}@else 0 @endif" >
             @if(!empty($result['cart']))
              <input type="hidden"  name="customers_basket_id" value="{{$result['cart'][0]->customers_basket_id}}" >
             @endif


             @if(count($result['detail']['product_data'][0]->attributes)>0)
             <div class="pro-options row">
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
               
                 <div class="attributes col-12 col-md-4 box">
                     <label class="">{{ $attributes_data['option']['name'] }}</label>
                     <div class="select-control">
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
                             <option @if($values_data['is_default']) selected @endif attributes_value="{{ $values_data['products_attributes_id'] }}" value="{{ $values_data['id'] }}" prefix = '{{ $values_data['price_prefix'] }}'  value_price ="{{ $values_data['price']+0 }}" >{{ $values_data['value'] }}</option>
                           @endforeach
                         @endif
                       </select>
                     </div> 
                   </div>                 
               
               @endforeach
             </div>
             @endif
        
      
             @if(!empty($result['detail']['product_data'][0]->flash_start_date))
             <div class="countdown pro-timer" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Countdown Timer')" id="counter_{{$result['detail']['product_data'][0]->products_id}}" >                               
               <span class="days">0<small>@lang('website.Days') </small></span>
               <span class="hours">0<small>@lang('website.Hours')</small></span>
               <span class="mintues">0<small>@lang('website.Minutes')</small></span>
               <span class="seconds">0<small>@lang('website.Seconds')</small></span>
             </div>
             @endif
          
          <div class="pro-counter" @if(!empty($result['detail']['product_data'][0]->flash_start_date) and $result['detail']['product_data'][0]->server_time < $result['detail']['product_data'][0]->flash_start_date ) style="display: none" @endif>
              <div class="input-group item-quantity">                    
                  {{-- <input type="text" id="quantity1" name="quantity" class="form-control" value="10">                       --}}
                  <input type="text" readonly name="quantity" class="form-control qty" value="@if(!empty($result['cart'])) {{$result['cart'][0]->customers_basket_quantity}} @else @if($result['detail']['product_data'][0]->products_min_order>0 and $result['detail']['product_data'][0]->defaultStock > $result['detail']['product_data'][0]->products_min_order) {{$result['detail']['product_data'][0]->products_min_order}} @else 1 @endif @endif"  min="{{$result['detail']['product_data'][0]->products_min_order}}" max="{{$result['detail']['product_data'][0]->products_max_stock}}">              
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
                          @if($result['commonContent']['settings']['Inventory'])
                          <button class="btn btn-secondary btn-lg swipe-to-top  add-to-Cart stock-cart" hidden type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                          <button class="btn btn-danger btn btn-lg swipe-to-top  stock-out-cart" hidden type="button">@lang('website.Out of Stock')</button>
                          @else
                          <button class="btn btn-secondary btn-lg swipe-to-top  add-to-Cart"  type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Add to Cart')</button>
                          @endif
                    @endif
                  @endif

                  @if($result['detail']['product_data'][0]->products_type == 2)
                    <a href="{{$result['detail']['product_data'][0]->products_url}}" target="_blank" class="btn btn-secondary btn-lg swipe-to-top">@lang('website.External Link')</a>
                  @endif
                
        
          </div>

          
        </form>

          <div class="pro-sub-buttons">
              <div class="buttons">
                  <button class="btn btn-link is_liked" products_id="<?=$result['detail']['product_data'][0]->products_id?>" style="padding-left: 0;"><i class="fas fa-heart"></i> @lang('website.Add to Wishlist') </button>
                  <button type="button" class="btn btn-link" onclick="myFunction3({{$result['detail']['product_data'][0]->products_id}})"><i class="fas fa-align-right"></i>@lang('website.Add to Compare')</button>
              
              </div>
              <!-- AddToAny BEGIN -->
              <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                <a class="a2a_button_facebook"></a>
                <a class="a2a_button_twitter"></a>
                <a class="a2a_button_email"></a>
                </div>
                <script async src="https://static.addtoany.com/menu/page.js"></script>
                <!-- AddToAny END -->
              
          </div>
        
        </div>
      </div>
        <div class="row">
            <div class="col-12 col-md-12">
              <div class="nav nav-pills" role="tablist">
                <a class="nav-link nav-item  active" href="#description" id="description-tab" data-toggle="pill" role="tab">@lang('website.Descriptions')</a> 
                <a class="nav-link nav-item" href="#review" id="review-tab" data-toggle="pill" role="tab" >@lang('website.Reviews')</a>
              </div> 
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active show" id="description" aria-labelledby="description-tab">
                  <?=stripslashes($result['detail']['product_data'][0]->products_description)?>                        
                </div>  
                <div role="tabpanel" class="tab-pane fade " id="review" aria-labelledby="review-tab">
                  <div class="reviews">
                    @if(isset($result['detail']['product_data'][0]->reviewed_customers))
                      <div class="review-bubbles">
                          <h2>
                            @lang('website.Customer Reviews')
                          </h2>                            
                            @foreach($result['detail']['product_data'][0]->reviewed_customers as $key=>$rev)
                            <div class="review-bubble-single">
                                <div class="review-bubble-bg">
                                  <div class="pro-rating">
                                    <fieldset class="disabled-ratings">                                           
                                      <label class = "full fa @if($rev->reviews_rating >= 5) active @endif" for="star_5" title="@lang('website.awesome_5_stars')"></label>
                                      <label class = "full fa @if($rev->reviews_rating >= 4) active @endif" for="star_4" title="@lang('website.pretty_good_4_stars')"></label>                                          
                                      <label class = "full fa @if($rev->reviews_rating >= 3) active @endif" for="star_3" title="@lang('website.pretty_good_3_stars')"></label>                                          
                                      <label class = "full fa @if($rev->reviews_rating >= 2) active @endif" for="star_2" title="@lang('website.meh_2_stars')"></label>
                                       <label class = "full fa @if($rev->reviews_rating >= 1) active @endif" for="star1" title="@lang('website.meh_1_stars')"></label>
                                    </fieldset>                                          
                                  </div>
                                    <h4>{{$rev->customers_name}}</h4>
                                    <span>{{date("d-M-Y", strtotime($rev->created_at))}}</span>
                                    <p>{{$rev->reviews_text}}</p>
                                </div>
                                
                            </div>
                            @endforeach                            
                      </div>
                      @endif
                      @if(Auth::guard('customer')->check())
                      <div class="write-review">
                        <form id="idForm">
                          {{csrf_field()}}
                          <input value="{{$result['detail']['product_data'][0]->products_id}}" type="hidden" name="products_id">
                        <h2>@lang('website.Write a Review')</h2>
                        <div class="write-review-box">
                            <div class="from-group row mb-3">
                                <div class="col-12"> <label for="inlineFormInputGroup2">@lang('website.Rating')</label></div>
                                <div class="pro-rating col-12">

                                  <fieldset class="ratings">
                                    
                                    <input type="radio" id="star5" name="rating" value="5" class="rating"/>
                                    <label class = "full fa" for="star5" title="@lang('website.awesome_5_stars')"></label>


                                    <input type="radio" id="star4" name="rating" value="4" class="rating"/>
                                    <label class="full fa" for="star4" title="@lang('website.pretty_good_4_stars')"></label>

                                    <input type="radio" id="star3" name="rating" value="3" class="rating"/>
                                    <label class = "full fa" for="star3" title="@lang('website.pretty_good_3_stars')"></label>

                                    <input type="radio" id="star2" name="rating" value="2" class="rating"/>
                                    <label class="full fa" for="star2" title="@lang('website.meh_2_stars')"></label>

                                    <input type="radio" id="star1" name="rating" value="1" class="rating"/>
                                    <label class = "full fa" for="star1" title="@lang('website.meh_1_stars')"></label> 
                                  
                                </fieldset>                                     
                                    
                                </div>
                            </div>                              
                           
                              <div class="from-group row mb-3">
                                  <div class="col-12"> <label for="inlineFormInputGroup3">@lang('website.Review')</label></div>
                                  <div class="input-group col-12">                                      
                                    <textarea name="reviews_text" id="reviews_text" class="form-control" id="inlineFormInputGroup3" placeholder="@lang('website.Write Your Review')"></textarea>
                                  </div>
                              </div>

                              <div class="alert alert-danger" hidden id="review-error" role="alert">
                               @lang('website.Please enter your review')
                              </div>

                              <div class="from-group">
                                  <button type="submit" id="review_button" disabled class="btn btn-secondary swipe-to-top">@lang('website.Submit')</button>                                    
                              </div>
                        </div>
                        
                      </form>
                      </div>
                      @endif
                  </div>

                    
                </div> 
            </div>
        </div>      
    
      </div>

    </div>
      @if($result['top_seller']['success']==1)
      <div class="col-12 col-lg-2">
        <div class="banner-full slider-pcontent">
          <h5 >@lang('website.Best Sellers')</h5>
          <div class="product-carousel-js5">    

            @foreach($result['top_seller']['product_data'] as $key=>$products)
                                      
              <div class="product">
                  <article>
                    <div class="thumb">
                      <div class="badges">
                        @if($products->is_feature==1)
                        <span class="badge badge-success">@lang('website.Featured')</span> 
                        @endif 
                      </div> 

                      <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
                    </div>                        
                  </article>
              </div> 

            @endforeach
          
          </div>  
        </div>
    

      </div>
      @endif

  </div>
    </div>
  </div>
</div>
</div>
</div>
</section>


<section class="product-content pro-content">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-12 col-lg-6">
              <div class="pro-heading-title">
                <h2> @lang('website.Related Products')
                </h2>
                <p> 
                  @lang('website.Related Products Text')
                </div>
          </div>
    
        </div>
  </div>
  <div class="general-product">
    <div class="container p-0">
        <div class="product-carousel-js">      
              @foreach($result['simliar_products']['product_data'] as $key=>$products)
                @if($result['detail']['product_data'][0]->products_id != $products->products_id)                     
                <div class="slik">
                  @include('web.common.product')
                </div>  
                @endif
                @endforeach  
          </div>  
    </div>
  </div>  

  @else
<div class="col-12">
<div class="container">
<h3>@lang('website.No Record Found!')</h3>
</div>
</div>
@endif
  <script>

    jQuery(document).ready(function(e) {
    
      @if(!empty($result['detail']['product_data'][0]->flash_start_date))
         @if( date("Y-m-d",$result['detail']['product_data'][0]->server_time) >= date("Y-m-d",$result['detail']['product_data'][0]->flash_start_date))
          var product_div_{{$result['detail']['product_data'][0]->products_id}} = 'product_div_{{$result['detail']['product_data'][0]->products_id}}';
        var  counter_id_{{$result['detail']['product_data'][0]->products_id}} = 'counter_{{$result['detail']['product_data'][0]->products_id}}';
        var inputTime_{{$result['detail']['product_data'][0]->products_id}} = "{{date('M d, Y H:i:s' ,$result['detail']['product_data'][0]->flash_expires_date)}}";
    
        // Set the date we're counting down to
        var countDownDate_{{$result['detail']['product_data'][0]->products_id}} = new Date(inputTime_{{$result['detail']['product_data'][0]->products_id}}).getTime();
    
        // Update the count down every 1 second
        var x_{{$result['detail']['product_data'][0]->products_id}} = setInterval(function() {
    
          // Get todays date and time
          var now = new Date().getTime();
    
          // Find the distance between now and the count down date
          var distance_{{$result['detail']['product_data'][0]->products_id}} = countDownDate_{{$result['detail']['product_data'][0]->products_id}} - now;
    
          // Time calculations for days, hours, minutes and seconds
          var days_{{$result['detail']['product_data'][0]->products_id}} = Math.floor(distance_{{$result['detail']['product_data'][0]->products_id}} / (1000 * 60 * 60 * 24));
          var hours_{{$result['detail']['product_data'][0]->products_id}} = Math.floor((distance_{{$result['detail']['product_data'][0]->products_id}} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes_{{$result['detail']['product_data'][0]->products_id}} = Math.floor((distance_{{$result['detail']['product_data'][0]->products_id}} % (1000 * 60 * 60)) / (1000 * 60));
          var seconds_{{$result['detail']['product_data'][0]->products_id}} = Math.floor((distance_{{$result['detail']['product_data'][0]->products_id}} % (1000 * 60)) / 1000);
          var days_text = "@lang('website.Days')";
          // Display the result in the element with id="demo"
          document.getElementById(counter_id_{{$result['detail']['product_data'][0]->products_id}}).innerHTML = "<span class='days'>"+days_{{$result['detail']['product_data'][0]->products_id}} + "<small>@lang('website.Days')</small></span> <span class='hours'>" + hours_{{$result['detail']['product_data'][0]->products_id}} + "<small>@lang('website.Hours')</small></span> <span class='mintues'> "
          + minutes_{{$result['detail']['product_data'][0]->products_id}} + "<small>@lang('website.Minutes')</small></span> <span class='seconds'>" + seconds_{{$result['detail']['product_data'][0]->products_id}} + "<small>@lang('website.Seconds')</small></span> ";
    
          // If the count down is finished, write some text
          if (distance_{{$result['detail']['product_data'][0]->products_id}} < 0) {
          clearInterval(x_{{$result['detail']['product_data'][0]->products_id}});
          //document.getElementById(counter_id_{{$result['detail']['product_data'][0]->products_id}}).innerHTML = "EXPIRED";
          document.getElementById('product_div_{{$result['detail']['product_data'][0]->products_id}}').remove();
          }
        }, 1000);
           @endif
       @endif
    
  
    });
    </script>

</section>