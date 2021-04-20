<div class="product product4 ">
             <article>
              <div class="thumb">
              <div class="badges">
        <?php
        $currency = \App\Models\Core\Currency::where('id',session('currency_id'))->pluck('decimal_places');
        $decimal_places = count($currency) > 0 ? $currency[0] : 2;
        $current_date = date("Y-m-d", strtotime("now"));

        $string = substr($products->products_date_added, 0, strpos($products->products_date_added, ' '));
        $date = date_create($string);
        date_add($date, date_interval_create_from_date_string($result['commonContent']['settings']['new_product_duration'] . " days"));
        $after_date = date_format($date, "Y-m-d");
        if ($after_date >= $current_date) {
          print '<span class="badge badge-info">';
          print __('website.New');
          print '</span>';
        }
        ?>
        <?php
        if (!empty($products->discount_price)) {
          $discount_price = $products->discount_price * session('currency_value');
        }
        $orignal_price = $products->products_price * session('currency_value');

        if (!empty($products->discount_price)) {

          if (($orignal_price + 0) > 0) {
            $discounted_price = $orignal_price - $discount_price;
            $discount_percentage = $discounted_price / $orignal_price * 100;
          } else {
            $discount_percentage = 0;
            $discounted_price = 0;
          }
        ?>

          <span class="badge badge-danger" data-toggle="tooltip" data-placement="bottom" title="<?php echo (int) $discount_percentage; ?>% @lang('website.off')"><?php echo (int) $discount_percentage; ?>%</span>
        <?php } ?>


        @if($products->is_feature == 1)
        <span class="badge badge-success">@lang('website.Featured')</span>

        @endif



      </div>
                <div class="product-action-vertical">
                 
                  <a class="icon active swipe-to-top is_liked" products_id="<?= $products->products_id ?>" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Wishlist')">
                    <i class="fas fa-heart"></i>
                  </a>
                <div class="icon swipe-to-top modal_show"  products_id="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Quick View')">
                  <i class="fas fa-eye"></i></div>
                <a onclick="myFunction3({{$products->products_id}})" class="icon swipe-to-top" data-toggle="tooltip" data-placement="bottom" data-original-title="@lang('website.Compare')"><i class="fas fa-align-right" data-fa-transform="rotate-90"></i></a>
            
                </div>
         
                <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
              </div>
               
              <div class="content">
               
                <h5 class="title text-center"><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">{{$products->products_name}}</a></h5>
                <p><?php

                $cat_name = '';
                foreach ($products->categories as $key => $category) {
                  $cat_name = $category->categories_name;
                }

                echo $cat_name;
                ?></p>
                <div class="price">
                  @if(!empty($products->discount_price))
                  {{Session::get('symbol_left')}}&nbsp;{{$discount_price+0}}&nbsp;{{Session::get('symbol_right')}}
                  <span> {{Session::get('symbol_left')}}{{number_format($orignal_price+0 , $decimal_places )}}{{Session::get('symbol_right')}}</span>
                  @else
                  {{Session::get('symbol_left')}}&nbsp;{{number_format($orignal_price+0 , $decimal_places )}}&nbsp;{{Session::get('symbol_right')}}
                  @endif
               </div>
              </div>                 
           
              <div class="product-action">
                <a class="btn  btn-secondary swipe-to-top" href="{{ URL::to('/product-detail/'.$products->products_slug)}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.View Detail')">@lang('website.View Detail')</a>
              </div><!-- End .product-action -->
             </article>
          </div>