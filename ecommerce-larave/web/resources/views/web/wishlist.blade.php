@extends('web.layout')
@section('content')
<!-- wishlist Content -->
<style>
.wishlist-content .media-main .media img {
    width: auto; !important;
    height: 160px;
    border: 1px solid #ddd;
    margin-right: 1rem;
}
.wishlist-content .media-main .media {
    padding: 20px 2px; !important;
}

.price span {
    color: #6c757d;
    text-decoration: line-through;
    margin-left: 10px;
    font-size: 1.075rem;
    line-height: 1.5;
	color: #6c757d !important;
}
h5 {

	text-align: center;
    line-height: 250px;
	
}

</style>
<section class="wishlist-content my-4">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-3">
				<div class="heading">
						<h2>
								@lang('website.My Account')
						</h2>
						<hr >
					</div>

				<ul class="list-group">
						<li class="list-group-item">
								<a class="nav-link" href="{{ URL::to('/profile')}}">
										<i class="fas fa-user"></i>
									@lang('website.Profile')
								</a>
						</li>
						<li class="list-group-item">
								<a class="nav-link" href="{{ URL::to('/wishlist')}}">
										<i class="fas fa-heart"></i>
								 @lang('website.Wishlist')
								</a>
						</li>
						<li class="list-group-item">
								<a class="nav-link" href="{{ URL::to('/orders')}}">
										<i class="fas fa-shopping-cart"></i>
									@lang('website.Orders')
								</a>
						</li>
						<li class="list-group-item">
								<a class="nav-link" href="{{ URL::to('/shipping-address')}}">
										<i class="fas fa-map-marker-alt"></i>
								 @lang('website.Shipping Address')
								</a>
						</li>
						<li class="list-group-item">
								<a class="nav-link" href="{{ URL::to('/logout')}}">
										<i class="fas fa-power-off"></i>
									@lang('website.Logout')
								</a>
						</li>
					</ul>

			</div>
			<div class="col-12 col-lg-9 ">
					<div class="heading">
							<h2>
									@lang('website.Wishlist')
							</h2>
							<hr >
						</div>

					<div class="col-12 media-main">
						<?php $i=0;?>
						@if(!empty($result['products']['product_data']) and count($result['products']['product_data'])>0)
						@foreach($result['products']['product_data'] as $key=>$products)  
						<div class="product">
						@if($i>0)
						<hr class="border-line">
						@endif
						<?php $i++; ?>
							<article>

								<div class="media">
									<img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}">
									<div class="media-body">
									  <div class="row">
										<div class="col-12 col-md-8  texting">
										  <h4 class="title"><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">{{$products->products_name}}</a></h4>
										  
										  
										  
										  

  
										  <div class="price"> 
											


												<?php

            if(!empty($products->discount_price)){
              $discount_price = $products->discount_price * session('currency_value');
            }
            if(!empty($products->flash_price)){
              $flash_price = $products->flash_price * session('currency_value');
            }
              $orignal_price = $products->products_price * session('currency_value');


             if(!empty($products->discount_price)){

              if(($orignal_price+0)>0){
                $discounted_price = $orignal_price-$discount_price;
                $discount_percentage = $discounted_price/$orignal_price*100;
                $discounted_price = $products->discount_price;

             }else{
               $discount_percentage = 0;
               $discounted_price = 0;
             }
            }
            else{
              $discounted_price = $orignal_price;
            }
            ?>
            @if(!empty($products->flash_price))
            <sub class="total_price">{{Session::get('symbol_left')}}{{$flash_price+0}}{{Session::get('symbol_right')}}</sub>
            <span>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}} </span> 
            @elseif(!empty($products->discount_price))
            <price class="total_price">{{Session::get('symbol_left')}}{{$discount_price+0}}{{Session::get('symbol_right')}}</price>
            <span>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}} </span> 
            @else
            <price class="total_price">{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</price>
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
						
						@endforeach
						@else
							<h5>@lang('website.No Record Found!')</h5>
						@endif
					</div>
					

				<!-- ............the end..... -->
			</div>
		</div>
	</div>
</section>
@endsection
