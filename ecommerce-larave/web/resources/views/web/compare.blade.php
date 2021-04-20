@extends('web.layout')
@section('content')

<style>

.compare-content .table tbody tr td
{

  padding: 0.75rem 0.75rem !important

}
.price-tag span {
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
  margin: 0 auto;
  
}
</style>

<div class="container-fuild">
  <nav aria-label="breadcrumb">
      <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('website.COMPARE PRODUCT')</li>
          </ol>
      </div>
    </nav>
</div> 



<!-- Compare Content -->
<section class="compare-content pro-content">

  <div class="container">
    <div class="page-heading-title">
        <h2> @lang('website.COMPARE PRODUCT') 
        </h2>
     
        </div>
</div>

  <div class="container">
    <div class="row">
    @if(empty($result['products']) and count($result['products'])==0)
    <h5>@lang('website.No Record Found!')</h5>        
    @else		
      @foreach($result['products'] as $key=>$products)
      <div class="col-lg-4">
          <table class="table">
              <thead>
                <td align="center">
                  <div class="img-div">
                      <img class="img-fluid" src="{{$products['product_data'][0]->image_path}}">
                  </div>

                </td>
              </thead>

              <tbody>
                <tr>
                  <td>
                    <h2 >{{$products['product_data'][0]->products_name}}</h2>
                  </td>

                </tr>
                <tr>
                  <td>
                    <span>@lang('website.Price')&nbsp;:&nbsp;</span>
                    <span class="price-tag">
                    <?php

if(!empty($products['product_data'][0]->discount_price)){
  $discount_price = $products['product_data'][0]->discount_price * session('currency_value');
}
if(!empty($products['product_data'][0]->flash_price)){
  $flash_price = $products['product_data'][0]->flash_price * session('currency_value');
}
  $orignal_price = $products['product_data'][0]->products_price * session('currency_value');


 if(!empty($products['product_data'][0]->discount_price)){

  if(($orignal_price+0)>0){
    $discounted_price = $orignal_price-$discount_price;
    $discount_percentage = $discounted_price/$orignal_price*100;
    $discounted_price = $products['product_data'][0]->discount_price;

 }else{
   $discount_percentage = 0;
   $discounted_price = 0;
 }
}
else{
  $discounted_price = $orignal_price;
}
?>
@if(!empty($products['product_data'][0]->flash_price))
<sub class="total_price">{{Session::get('symbol_left')}}{{$flash_price+0}}{{Session::get('symbol_right')}}</sub>
<span>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}} </span> 
@elseif(!empty($products['product_data'][0]->discount_price))
<price class="total_price">{{Session::get('symbol_left')}}{{$discount_price+0}}{{Session::get('symbol_right')}}</price>
<span>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}} </span> 
@else
<price class="total_price">{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</price>
@endif
                      
                  </span>
                </td>
                </tr>
                <tr>
                  <td>
                    <span>@lang('website.Discount')&nbsp;:&nbsp;</span>
                    <?php
                                                $current_date = date("Y-m-d", strtotime("now"));

                                                $string = substr($products['product_data'][0]->products_date_added, 0, strpos($products['product_data'][0]->products_date_added, ' '));
                                                $date=date_create($string);
                                                date_add($date,date_interval_create_from_date_string($web_setting[20]->value." days"));


                                                $after_date = date_format($date,"Y-m-d");

                                                if($after_date>=$current_date){
                                                }
                                                $discount_percentage = 0;
                                                if(!empty($products['product_data'][0]->discount_price)){
                                                    $discount_price = $products['product_data'][0]->discount_price;
                                                    $orignal_price = $products['product_data'][0]->products_price;

                                                    if(($orignal_price+0)>0){
                                                      $discounted_price = $orignal_price-$discount_price;
                                                      $discount_percentage = $discounted_price/$orignal_price*100;
                                                    }else{
                                                      $discount_percentage = 0;
                                                    }
                                                                      
                                                }
                                                echo "<span style='margin-left:15px' class='discount-tag'>".(int)$discount_percentage."%</span>";
                    ?>
                  </td>
                </tr>
                
                <tr>
                  <td>
                    <span>@lang('website.Categories')&nbsp;:&nbsp;</span>
                    <?php
                            $cates = '';  
                    ?>
                            @foreach($products['product_data'][0]->categories as $key=>$category)
                                
                              <?php
                                if ($cates != '') $cates .= ' / '; 
                                $cates .=  "<a href=".url('shop?category='.$category->categories_name).">".$category->categories_name."</a>";
                              ?>  
                              
                            @endforeach
                    <?php 
                            echo $cates;
                    ?>

              
                  </td>
                </tr>
                @php  foreach($products['product_data'][0]->attributes as $f) { @endphp
                <tr>
                  <td>
                    <span>{{$f['option']['name']}}&nbsp;:&nbsp;</span>
                    @php  foreach($f['values'] as $d) { @endphp
                    <span style="margin-left:4px;"><small>{{$d['value']}}</small></span>
                    @php   } @endphp
                  </td>
                </tr>
                @php   } @endphp
                <tr>
                  <td>
                    <div class="detail-buttons">
                        <a href="{{ URL::to('/product-detail/'.$products['product_data'][0]->products_slug)}}" class="btn btn-secondary">View Details</a>
                        <div class="share"><a href="{{ URL::to("/deletecompare")}}/{{$products['product_data'][0]->products_id}}">Remove &nbsp;<i class="fas fa-trash-alt"></i></a> </div>

                    </div>

                  </td>

                </tr>
              </tbody>
            </table>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</section>

@endsection
