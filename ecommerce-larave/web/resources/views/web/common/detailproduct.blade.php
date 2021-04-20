<div class="product">
    <article>
        <div class="thumb">
          <div class="icons mobile-icons d-lg-none d-xl-none">
              <div class="icon-liked">
                <a class="icon active is_liked" products_id="<?=$products->products_id?>">
                  <i class="fas fa-heart"></i>
                  <span  class="badge badge-secondary counter"  >{{$products->products_liked}}</span>
                </a>
              </div>
              <div class="icon"><i class="fas fa-eye"></i></div>
              <a href="{{url('compare')}}" class="icon"><i class="fas fa-align-right" data-fa-transform="rotate-90"></i></a>
            </div>
          <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
       </div>
       <?php

          if(!empty($products->discount_price)){
            $discount_price = $products->discount_price * session('currency_value');
          }
          $orignal_price = $products->products_price * session('currency_value');
          
           if(!empty($products->discount_price)){

            if(($orignal_price+0)>0){
           $discounted_price = $orignal_price-$discount_price;
           $discount_percentage = $discounted_price/$orignal_price*100;
           }else{
             $discount_percentage = 0;
             $discounted_price = 0;
         }
       ?>
       <span class="discount-tag"><?php echo (int)$discount_percentage; ?>%</span>
      <?php }
      $current_date = date("Y-m-d", strtotime("now"));

      $string = substr($products->products_date_added, 0, strpos($products->products_date_added, ' '));
      $date=date_create($string);
      date_add($date,date_interval_create_from_date_string($web_setting[20]->value." days"));

      //echo $top_seller->products_date_added . "<br>";
      $after_date = date_format($date,"Y-m-d");

      if($after_date>=$current_date){
        print '<span class="discount-tag">';
        print __('website.New');
        print '</span>';
      }
       ?>
      <span class="tag">
        @foreach($products->categories as $key=>$category)
            {{$category->categories_name}}@if(++$key === count($products->categories)) @else, @endif
        @endforeach
      </span>
      <h2 class="title text-center"><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">{{$products->products_name}}</a></h2>
      <div class="price">
        @if(!empty($products->discount_price))
        {{Session::get('symbol_left')}}&nbsp;{{$discount_price+0}}&nbsp;{{Session::get('symbol_right')}}
        <span> {{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</span>
        @else
        {{Session::get('symbol_left')}}&nbsp;{{$orignal_price+0}}&nbsp;{{Session::get('symbol_right')}}
        @endif
      </div>
      <div class="product-hover d-none d-lg-block d-xl-block">
        <div class="icons">
            <div class="icon-liked">
              <a class="icon active is_liked" products_id="<?=$products->products_id?>">
                <i class="fas fa-heart"></i>
                <span  class="badge badge-secondary counter"  >{{$products->products_liked}}</span>
              </a>
            </div>
          <!-- <div class="icon modal_show" data-toggle="modal" data-target="#myModal" products_id="{{$products->products_id}}"><i class="fas fa-eye"></i></div> -->
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
