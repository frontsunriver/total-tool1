@extends('web.layout')
@section('content')

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

                                                    <div id="carouselExampleIndicators4" class="carousel slide" data-ride="carousel">
                                                      <ol class="carousel-indicators">
                                                        @foreach( $result['detail']['product_data'][0]->images as $key=>$images )
                                                          <li data-target="#carouselExampleIndicators4" data-slide-to="{{ $key }}" class="@if($key==0) active @endif"></li>
                                                        @endforeach
                                                      </ol>
                                                      <div class="carousel-inner">
                                                        @php

                                                          if(!empty($result['detail']['product_data'][0]->discount_price) or !empty($result['detail']['product_data'][0]->flash_price)){
                                          if(!empty($result['detail']['product_data'][0]->discount_price)){
                                                                $discount_price = $result['detail']['product_data'][0]->discount_price;
                                          }else{
                                            $discount_price = $result['detail']['product_data'][0]->flash_price;
                                          }
                                                              $orignal_price = $result['detail']['product_data'][0]->products_price;

                                                              if(($orignal_price+0)>0){
                                                                  $discounted_price = $orignal_price-$discount_price;
                                                                  $discount_percentage = $discounted_price/$orignal_price*100;
                                                              }else{
                                                                  $discount_percentage = 0;
                                                              }
                                                              echo "<span class='discount-tag'>".(int)$discount_percentage."%</span>";
                                                          }

                                        @endphp

                                                             @foreach( $result['detail']['product_data'][0]->images as $key=>$images )
                                                          <div class="carousel-item  @if($key==0) active @endif">
                                                            <img width="100%" class="first-slide"  src="{{asset('').$images->image_path }}" width="100%" alt="First slide">
                                                            </a>
                                                          </div>

                                                        @endforeach


                                                      </div>
                                                      <a class="carousel-control-prev" href="#carouselExampleIndicators4" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">@lang('website.Previous')</span>
                                                      </a>
                                                      <a class="carousel-control-next" href="#carouselExampleIndicators4" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">@lang('website.Next')</span>
                                                      </a>
                                                </div>

                      </div>
                          <div class="col-12 col-lg-7" >
                              <h1>{{$result['detail']['product_data'][0]->products_name}}</h1>
                              <div class="list-main">
                                  <div class="icon-liked">
                                      <a onclick="myLike({{$result['detail']['product_data'][0]->products_id}})" class="icon active">
                                        <i class="fas fa-heart"></i>
                                        <span products_id='{{$result['detail']['product_data'][0]->products_id}}' class=" is_liked badge badge-secondary" id="like_count">{{$result['detail']['product_data'][0]->products_liked}}</span>
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
                                      @if($result['detail']['product_data'][0]->defaultStock == 0)
                                      <li class="outstock"><i class="fas fa-check"></i>@lang('website.Out of Stock')</li>
                                      @else
                                      <li class="instock"><i class="fas fa-check"></i>@lang('website.In stock')</li>
                                      @endif
                                      @endif
                                  </ul>
                               @include('web.common.scripts.Like')
                              </div>
                              <form name="attributes" id="add-Product-form" method="post" >
                                  <input type="hidden" name="products_id" value="{{$result['detail']['product_data'][0]->products_id}}">

                                  <input type="hidden" name="products_price" id="products_price" value="@if(!empty($result['detail']['product_data'][0]->flash_price)) {{$result['detail']['product_data'][0]->flash_price+0}} @elseif(!empty($result['detail']['product_data'][0]->discount_price)){{$result['detail']['product_data'][0]->discount_price+0}}@else{{$result['detail']['product_data'][0]->products_price+0}}@endif">

                                  <input type="hidden" name="checkout" id="checkout_url" value="@if(!empty(app('request')->input('checkout'))) {{ app('request')->input('checkout') }} @else false @endif" >

                                  <input type="hidden" id="max_order" value="@if(!empty($result['detail']['product_data'][0]->products_max_stock)) {{ $result['detail']['product_data'][0]->products_max_stock }} @else 0 @endif" >

                              <div class="controls">
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
                                  <div class="select-control col-12 col-lg-4">
                                      <select name="{{ $attributes_data['option']['id'] }}" onChange="getQuantity()" class="form-control attributeid_<?=$index++?>" attributeid = "{{ $attributes_data['option']['id'] }}">
                                        <option selected>Select {{ $attributes_data['option']['name'] }}</option>
                                        @foreach( $attributes_data['values'] as $values_data )
                                        <option attributes_value="{{ $values_data['products_attributes_id'] }}" value="{{ $values_data['id'] }}" prefix = '{{ $values_data['price_prefix'] }}'  value_price ="{{ $values_data['price']+0 }}">{{ $values_data['value'] }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                  @endforeach
                                @endif
                                <div class="col-12 col-lg-4">
                                  <div class="input-group item-quantity">

                                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="@if($result['detail']['product_data'][0]->products_min_order>0) {{$result['detail']['product_data'][0]->products_min_order}} @else 1 @endif" min="@if($result['detail']['product_data'][0]->products_min_order>0) {{$result['detail']['product_data'][0]->products_min_order}} @else 1 @endif" max="@if(!empty($result['detail']['product_data'][0]->products_max_stock) and $result['detail']['product_data'][0]->products_max_stock>0){{ $result['detail']['product_data'][0]->products_max_stock}}@else{{ $result['detail']['product_data'][0]->defaultStock}}@endif">

                                        <span class="input-group-btn">
                                            <button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
                                              <span class="fas fa-angle-up"></span>
                                            </button>

                                            <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                                <span class="fas fa-angle-down"></span>
                                            </button>
                                        </span>


                                </div>
                                </div>
                              </div>

                              <div class="product-buttons">
                                  <h2>Total Price:
                                    <span>
                                      <?php
                                          if(!empty($products->discount_price)){

                                              $discount_price = $products->discount_price;

                                              $orignal_price = $products->products_price;



                                                            if(($orignal_price+0)>0){
                                          $discounted_price = $orignal_price-$discount_price;
                                          $discount_percentage = $discounted_price/$orignal_price*100;
                                        }else{
                                          $discount_percentage = 0;
                                        }
                                      ?>
                                      <span class="discount-tag"><?php echo (int)$discount_percentage; ?>%</span>
                                     <?php } ?>
                                      @if(!empty($result['detail']['product_data'][0]->discount_price))
                                      @if($result['detail']['product_data'][0]->currency_symbol_left != null){{$result['detail']['product_data'][0]->currency_symbol_left}}@endif{{$result['detail']['product_data'][0]->discount_price+0}}@if($result['detail']['product_data'][0]->currency_symbol_right != null){{$result['detail']['product_data'][0]->currency_symbol_right}}@endif
                                      <span> @if($result['detail']['product_data'][0]->currency_symbol_left != null){{$result['detail']['product_data'][0]->currency_symbol_left}}@endif{{$result['detail']['product_data'][0]->price+0}}@if($result['detail']['product_data'][0]->currency_symbol_right != null){{$result['detail']['product_data'][0]->currency_symbol_right}}@endif</span>
                                      @else
                                      @if($result['detail']['product_data'][0]->currency_symbol_left != null){{$result['detail']['product_data'][0]->currency_symbol_left}}@endif{{$result['detail']['product_data'][0]->price+0}}@if($result['detail']['product_data'][0]->currency_symbol_right != null){{$result['detail']['product_data'][0]->currency_symbol_right}}@endif
                                      @endif
                                      <span>

                                    </span></h2>
                                    @if($result['detail']['product_data'][0]->products_min_order>0)
                                      <p>
                                      &nbsp; @lang('website.Min Order Limit:') {{ $result['detail']['product_data'][0]->products_min_order }}
                                        </p>
                                    @endif

                                    <div class="buttons">
                                     @if(!empty($result['detail']['product_data'][0]->flash_start_date) and $result['detail']['product_data'][0]->server_time < $result['detail']['product_data'][0]->flash_start_date )
                                      @else
                                       @if($result['detail']['product_data'][0]->products_type == 0)
                                       @if($result['commonContent']['settings']['Inventory'])
                                            @if($products->defaultStock < 0)
                                              <button type="button" class="btn  btn-danger swipe-to-top" products_id="{{$products->products_id}}">@lang('website.Out of Stock')</button>
                                            @else
                                              <button type="button" class="btn  btn-secondary cart swipe-to-top" products_id="{{$products->products_id}}">@lang('website.Add to Cart')</button>
                                            @endif
                                          @else
                                            <button type="button" class="btn  btn-secondary cart swipe-to-top" products_id="{{$products->products_id}}">@lang('website.Add to Cart')</button>
                                          @endif
                                        @else
                                             <button class="btn btn-secondary add-to-Cart stock-cart" hidden type="button" products_id="{{$result['detail']['product_data'][0]->products_id}}">@lang('website.Update')</button>
                                             @if($result['commonContent']['settings']['Inventory'])
                                             <button class="btn btn-danger stock-out-cart" hidden type="button">@lang('website.Out of Stock')</button>
                                             @endif
                                        @endif
                                      @endif
                                    </div>

                              </div>
                        </form>

                              <div class="row">
                                  <div class="col-md-12 tab-list">
                                    <div class="nav nav-pills" role="tablist">
                                      <a class="nav-link nav-item nav-index active show" href="#description" id="description-tab" data-toggle="pill" role="tab">Description</a>
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
                                              <p>
                                                  Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                                  sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                                  Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                                  nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                                  reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                                  Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Duis aute irure dolor in
                                                  reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Duis aute irure dolor in
                                                  reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                              </p>
                                              <p>
                                                  Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                                  sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                                  Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                                </p>
                                          </div>
                                      </div>
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
                        <div class="product">
                            <article>
                                <div class="thumb">
                                  <div class="icons mobile-icons d-lg-none d-xl-none">
                                      <div class="icon-liked">
                                        <a onclick="myLike({{$result['detail']['product_data'][0]->products_id}})" class="icon active">
                                          <i class="fas fa-heart"></i>
                                          <span class="badge badge-secondary">{{$products->products_liked}}</span>
                                        </a>
                                      </div>
                                      <div class="icon" data-toggle="modal" data-target="#myModal"><i class="fas fa-eye"></i></div>
                                      <a href="compare.html" class="icon"><i class="fas fa-align-right" data-fa-transform="rotate-90"></i></a>
                                    </div>
                                  <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
                               </div>
                               <?php
                                   if(!empty($products->discount_price)){

                                       $discount_price = $products->discount_price;

                                       $orignal_price = $products->products_price;



                                                     if(($orignal_price+0)>0){
                                   $discounted_price = $orignal_price-$discount_price;
                                   $discount_percentage = $discounted_price/$orignal_price*100;
                                 }else{
                                   $discount_percentage = 0;
                                 }
                               ?>
                               <span class="discount-tag"><?php echo (int)$discount_percentage; ?>%</span>
                              <?php } ?>
                              <span class="tag">
                                @foreach($products->categories as $key=>$category)
                                    {{$category->categories_name}}@if(++$key === count($products->categories)) @else, @endif
                                @endforeach
                              </span>
                              <h2 class="title text-center"><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">{{$products->products_name}}</a></h2>
                              <div class="price">
                                @if(!empty($products->discount_price))
                                @if($products->currency_symbol_left != null){{$products->currency_symbol_left}}@endif{{$products->discount_price+0}}@if($products->currency_symbol_right != null){{$products->currency_symbol_right}}@endif
                                <span> @if($products->currency_symbol_left != null){{$products->currency_symbol_left}}@endif{{$products->price+0}}@if($products->currency_symbol_right != null){{$products->currency_symbol_right}}@endif</span>
                                @else
                                @if($products->currency_symbol_left != null){{$products->currency_symbol_left}}@endif{{$products->price+0}}@if($products->currency_symbol_right != null){{$products->currency_symbol_right}}@endif
                                @endif
                              </div>
                            <div class="product-hover d-none d-lg-block d-xl-block">
                              <div class="icons">
                                  <div class="icon-liked">
                                    <a onclick="myLike({{$products->products_id}})" class="icon active">
                                      <i class="fas fa-heart"></i>
                                      <span  class="badge badge-secondary" id="like_count">{{$products->products_liked}}</span>
                                    </a>
                                  </div>
                                <div class="icon" data-toggle="modal" data-target="#myModal"><i class="fas fa-eye"></i></div>
                                  <a onclick="myFunction3({{$products->products_id}})"class="icon"><i class="fas fa-align-right" data-fa-transform="rotate-90"></i></a>
                              </div>
                              @include('web.common.scripts.addToCompare')
                              <div class="buttons">
                                         @if($products->products_type==0)
                                            @if(!in_array($products->products_id,$result['cartArray']))
                                                @if($products->defaultStock==0)
                                                    <button type="button" class="btn btn-block btn-danger" products_id="{{$products->products_id}}">@lang('website.Out of Stock')</button>
                                                @elseif($products->products_min_order>1)
                                                 <a class="btn btn-block btn-secondary" href="{{ URL::to('/product-detail/'.$products->products_slug)}}">@lang('website.View Detail')</a>
                                                @else
                                                    <button type="button" class="btn btn-block btn-secondary cart" products_id="{{$products->products_id}}">@lang('website.Add to Cart')</button>
                                                @endif
                                            @else
                                                <button type="button" class="btn btn-block btn-secondary active">@lang('website.Added')</button>
                                            @endif
                                        @elseif($products->products_type==1)
                                            <a class="btn btn-block btn-secondary" href="{{ URL::to('/product-detail/'.$products->products_slug)}}">@lang('website.View Detail')</a>
                                        @elseif($products->products_type==2)
                                            <a href="{{$products->products_url}}" target="_blank" class="btn btn-block btn-secondary">@lang('website.External Link')</a>
                                        @endif
                                    </div>
                            </div>
                            <div class="mobile-buttons d-lg-none d-xl-none">
                                      @if($products->products_type==0)
                                         @if(!in_array($products->products_id,$result['cartArray']))
                                             @if($products->defaultStock==0)
                                                 <button type="button" class="btn btn-block btn-danger" products_id="{{$products->products_id}}">@lang('website.Out of Stock')</button>
                                             @elseif($products->products_min_order>1)
                                              <a class="btn btn-block btn-secondary" href="{{ URL::to('/product-detail/'.$products->products_slug)}}">@lang('website.View Detail')</a>
                                             @else
                                                 <button type="button" class="btn btn-block btn-secondary cart" products_id="{{$products->products_id}}">@lang('website.Add to Cart')</button>
                                             @endif
                                         @else
                                             <button type="button" class="btn btn-block btn-secondary active">@lang('website.Added')</button>
                                         @endif
                                     @elseif($products->products_type==1)
                                         <a class="btn btn-block btn-secondary" href="{{ URL::to('/product-detail/'.$products->products_slug)}}">@lang('website.View Detail')</a>
                                     @elseif($products->products_type==2)
                                         <a href="{{$products->products_url}}" target="_blank" class="btn btn-block btn-secondary">@lang('website.External Link')</a>
                                     @endif
                                    </div>
                          </article>
                        </div>
                        @endif
                        @endif
                        @endforeach
                      </div>
                    </div>
                  </div>

            </div>
          </div>
        </section>

@endsection
