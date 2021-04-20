
            @if($result['products']['success']==1)
            @foreach($result['products']['product_data'] as $key=>$products)
            <div class="product">
                <article>
                    <div class="media">
                        <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
                        <div class="media-body">
                          <div class="row">
                            <div class="col-12 col-md-8  texting">
                              <h3 class="title"><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">{{$products->products_name}}</a></h3>
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
                            }
                           ?>


                              <div class="price"> @lang('website.Total Price'): 
                                @if(!empty($products->discount_price))
                                    <span>{{Session::get('symbol_left')}}&nbsp;{{$discount_price+0}}&nbsp;{{Session::get('symbol_right')}}</span>
                                    <del> {{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</del>
                                    @else
                                    <span>{{Session::get('symbol_left')}}&nbsp;{{$orignal_price+0}}&nbsp;{{Session::get('symbol_right')}}</span>
                                    @endif 
                               </div>
                              <div class="wishlist-discription">
                                <?=stripslashes($products->products_description)?>
                              </div>
                             
                              <div class="buttons">
                                @if($products->products_type==0)
                                @if(!in_array($products->products_id,$result['cartArray']))
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
                                        <button type="button" class="btn btn-secondary active swipe-to-top">@lang('website.Added')</button>
                                    @endif
                                @elseif($products->products_type==1)
                                    <a class="btn  btn-secondary swipe-to-top" href="{{ URL::to('/product-detail/'.$products->products_slug)}}">@lang('website.View Detail')</a>
                                @elseif($products->products_type==2)
                                    <a href="{{$products->products_url}}" target="_blank" class="btn  btn-secondary swipe-to-top">@lang('website.External Link')</a>
                                @endif
                              </div>
                            </div>
                            <div class="col-12 col-md-4 detail">
                              <div class="share"><a href="{{ URL::to("/UnlikeMyProduct")}}/{{$products->products_id}}">@lang('website.Remove') &nbsp;<i class="fas fa-trash-alt"></i></a> </div>
                            </div>
                            </div>
                        </div>									
                    </div>
                </article>
            </div>
                    <hr class="border-line">

            @endforeach
                @if(count($result['products']['product_data'])> 0 and $result['limit'] > $result['products']['total_record'])
                 <style>
                    #load_wishlist{
                        display: none;
                    }
                    #loaded_content{
                        display: block !important;
                    }
                    #loaded_content_empty{
                        display: none !important;
                    }
                 </style>
                @endif
            @elseif(count($result['products']['product_data'])==0 or $result['products']['success']==0)
            	<style>
             	#load_wishlist{
					display: none;
				}
				#loaded_content{
					display: none !important;
				}
				#loaded_content_empty{
					display: block !important;
				}
             </style>
            @endif
