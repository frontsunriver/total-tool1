<!-- Products content -->
@if(!empty($result['category_section']) and count($result['category_section'])>0)

  @foreach ($result['category_section'] as $item)
      <section class="categories-content pro-content">
        <div class="container">
          <div class="products-area">
            <div class="row justify-content-center">
              <div class="col-12 col-lg-6">
                <div class="pro-heading-title">
                  <h2> 
                    
                    {{$item->categories_name}}
                  </h2>
                  <p>
                    <?php echo stripslashes($item->categories_description); ?>
                    </p>
                  </div>
                </div>
            </div>
          
          </div>
        </div>
      <div class="row">
        <div class="container">
        
        {{-- {{ dd($item->products['success']) }} --}}
          @if($item->products['success']==1)
              <div class="categories-carousel-js">         
                
                    @foreach($item->products['product_data'] as $key=>$products)
                    {{-- {{dd($products)}} --}}
                    <div class="slick ">
                    {{-- <div class="col-12 col-sm-6 col-lg-3"> --}}
                      @include('web.common.product')
                    </div>
                    @endforeach               

                  </div>
                </div>
            <!-- 2nd tab --> 
            @endif
          </div>
        </div>          
          
      </section>
  @endforeach

@endif