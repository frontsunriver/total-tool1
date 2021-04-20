<section class="new-products-content pro-content" >
  <div class="container">
    <div class="products-area">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
          <div class="pro-heading-title">
            <h2> @lang('website.Top Selling of the Week')

            </h2>
            <p>
              @lang('website.Top Sellings Of the Week Detail')</p>
          </div>
        </div> 
      </div>
      <div class="row ">  
        
        @foreach($result['weeklySoldProducts']['product_data'] as $key=>$products)
        @if($key==0)

          <div class="col-12 col-lg-6">

            <div class="product product-ad">
              <article>
                <div class="badges">
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
                  
                    <span class="badge badge-danger"  data-toggle="tooltip" data-placement="bottom" title="<?php echo (int)$discount_percentage; ?>% off"><?php echo (int)$discount_percentage; ?>%</span>
                    <?php }?>
                    @if($products->is_feature == 1)
                      <span class="badge badge-success">@lang('website.Featured')</span>                                            
                                
                  @else
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
                  @endif   
                </div>
                <div class="detail">
                  <span class="tag">
                    <?php 
                    $cates = '';
                    foreach($products->categories as $key=>$category){
                      $cates = trim($category->categories_name);
                    } 
                    echo $cates ;                    
                    ?>                               
                </span>
                <h5 class="title"><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">{{$products->products_name}}</a></h5>
                <p class="discription">
                   <?php
                      $descriptions = strip_tags($products->products_description);
                      echo stripslashes($descriptions);
                    ?>
                </p>
                      
                <div class="price">                                    
                  @if(!empty($products->discount_price))
                    {{Session::get('symbol_left')}}&nbsp;{{$discount_price+0}}&nbsp;{{Session::get('symbol_right')}}<span>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</span>
                  @else
                    {{Session::get('symbol_left')}}&nbsp;{{$orignal_price+0}}&nbsp;{{Session::get('symbol_right')}}
                  @endif   
                </div>  
               
              <div class="pro-sub-buttons">
                  <div class="buttons">
                      <button type="button" class="btn  btn-link is_liked" products_id="<?=$products->products_id?>" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Add to Wishlist')"><i class="fas fa-heart"></i>@lang('website.Add to Wishlist')</button>
                      <button type="button" class="btn btn-link" onclick="myFunction3({{$products->products_id}})" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Add to Compare')"><i class="fas fa-align-right" ></i>@lang('website.Add to Compare')</button>
                  </div>
                  </div>          
             
                 </div>
                <picture>
                    <div class="product-hover">
                       
                        @if($products->products_type==0)
                          @if(!in_array($products->products_id,$result['cartArray']))
                              @if($result['commonContent']['settings']['Inventory'])
                              @if($products->defaultStock < 0)
                                  <button type="button"  class="btn btn-block btn-danger swipe-to-top" products_id="{{$products->products_id}}">@lang('website.Out of Stock')</button>
                              @else
                                  <button type="button" class="btn btn-block btn-secondary cart swipe-to-top" products_id="{{$products->products_id}}">@lang('website.Add to Cart')</button>
                              @endif
                              @else
                              <button type="button" class="btn btn-block btn-secondary cart swipe-to-top" products_id="{{$products->products_id}}">@lang('website.Add to Cart')</button>
                              @endif
                          @else
                              <button type="button" class="btn btn-block btn-secondary active swipe-to-top">@lang('website.Added')</button>
                          @endif
                      @elseif($products->products_type==1)
                          <a class="btn btn-block btn-secondary swipe-to-top" href="{{ URL::to('/product-detail/'.$products->products_slug)}}">@lang('website.View Detail')</a>
                      @elseif($products->products_type==2)
                          <a href="{{$products->products_url}}" target="_blank" class="btn btn-block btn-secondary swipe-to-top">@lang('website.External Link')</a>
                      @endif

                    </div>
                  <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
                </picture>
              
    
                 
              </article>
            </div>
          </div> 
          
          @endif
          @endforeach
          
          @if($result['weeklySoldProducts']['success']==1)
            @foreach($result['weeklySoldProducts']['product_data'] as $key=>$products)
            @if($key!=0)
            @if($key<=6)

          <div class="col-12 col-sm-6 col-lg-3">
            @include('web.common.product')
          </div>  
          @endif
          @endif
          @endforeach
          @endif
   
      </div>
    </div>
  </div>  
</section>