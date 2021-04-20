<div class="product product12">
    <article>
      <div class="thumb">
        <div class="badges">
        <?php 
        $current_date = date("Y-m-d", strtotime("now"));

        $string = substr($products->products_date_added, 0, strpos($products->products_date_added, ' '));
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
      
        <span class="badge badge-danger"  data-toggle="tooltip" data-placement="bottom" title="<?php echo (int)$discount_percentage; ?>% @lang('website.off')"><?php echo (int)$discount_percentage; ?>%</span>
        <?php }?>
        
      
      @if($products->is_feature == 1)
        <span class="badge badge-success">@lang('website.Featured')</span>                                            
      @endif  
        </div>
    
        <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
      </div>
      
      <div class="content">
        <span class="tag">
          <?php 
          
          $cat_name = '';
          foreach($products->categories as $key=>$category){
              $cat_name = $category->categories_name;
          }              
                
          echo $cat_name;
          ?>                                 
        </span>
        <h5 class="title"><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">{{$products->products_name}}</a></h5>
        <p>
          <?php
            $descriptions = strip_tags($products->products_name);
            echo stripslashes($descriptions);
          ?>
        </p>
        <div class="price">                     
          @if(!empty($products->discount_price))
            {{Session::get('symbol_left')}}&nbsp;{{$discount_price+0}}&nbsp;{{Session::get('symbol_right')}}
            <span> {{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</span>
          @else
            {{Session::get('symbol_left')}}&nbsp;{{$orignal_price+0}}&nbsp;{{Session::get('symbol_right')}}
          @endif                        
        </div>  
        <div class="pro-counter">
              <div class="input-group item-quantity">
                
                <input name="products_{{$products->products_id}}" type="text" readonly value="{{$products->products_min_order}}" class="form-control qty products_{{$products->products_id}}" min="{{$products->products_min_order}}" max="{{$products->products_max_stock}}">
                <span class="input-group-btn">
                    <button type="button" value="quantity" class="quantity-plus1 btn qtypluscart" data-type="plus" data-field="">
                        <i class="fas fa-plus"></i>
                    </button>
                
                    <button type="button" value="quantity" class="quantity-minus1 btn qtyminuscart" data-type="minus" data-field="">
                        <i class="fas fa-minus"></i>
                    </button>
                </span>
              </div>
              @if($products->products_type==0)
                @if($result['commonContent']['settings']['Inventory'])
                    @if($products->defaultStock<=0)
                    <button type="button" class="btn-secondary btn icon swipe-to-top" products_id="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Out of Stock')"><i class="fas fa-shopping-bag"></i></button>
                    @else
                    <button type="button" class="btn-secondary btn icon swipe-to-top cart" products_id="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Add to Cart')"><i class="fas fa-shopping-bag"></i></button>
                    @endif
                @else
                    <button type="button" class="btn-secondary btn icon swipe-to-top cart" products_id="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Add to Cart')"><i class="fas fa-shopping-bag"></i></button>
                @endif
              @else
              <a class="btn-secondary btn icon swipe-to-top cart" href="{{ URL::to('/product-detail/'.$products->products_slug)}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.View Detail')"><i class="fas fa-shopping-bag"></i></a>
              @endif    
        </div>
      
      </div>                 
    
    </article>
  </div>