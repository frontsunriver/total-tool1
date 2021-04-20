<!-- Products content -->
@if($result['products']['success']==1)

<section class="new-products-content pro-content" >
  <div class="container">
    <div class="products-area">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
          <div class="pro-heading-title">
            <h2> @lang('website.NEW ARRIVAL')
            </h2>
            <p>@lang('website.Newest Products Detail')
               </p>
          </div>
        </div>
      </div>
      <div class="row">      
        @if($result['products']['success']==1)
        @foreach($result['products']['product_data'] as $key=>$products)
        <div class="col-12 col-sm-6 col-lg-3">
          <!-- Product -->
          @include('web.common.product')
        </div>
        @endforeach
        @endif
   
      </div>
    </div>
  </div>  
</section>


@endif
