<!-- Products content -->
@if(!empty($result['commonContent']['categories']))
<section class="categories-content pro-content">
    <div class="container">
      <div class="products-area">
         <div class="row justify-content-center">
           <div class="col-12 col-lg-6">
             <div class="pro-heading-title">
               <h2> @lang('website.PRODUCT CATEGORIES')
               </h2>
               <p>
                 @lang('website.Categories Text For Home Page')
                </p>
               </div>
             </div>
         </div>
      
      </div>
    </div>
    @if($result['commonContent']['settings']['home_categories_img_icn'] == 'Image')
               

    <div class="general-product">
      <div class="container p-0">
        <div class="cat1-carousel-js">
    {{-- {{dd($result['commonContent']['settings']['home_categories_img_icn'] == 'Icon')}} --}}
    @foreach($result['commonContent']['categories'] as $categories_data)
          <div class="cat-banner">
            
            <figure class="categories-image">
              <a href="{{ URL::to('/shop?category='.$categories_data->slug)}}">
                
                <img class="img-fluid" src="{{asset('').$categories_data->path}}" alt="{{$categories_data->name}}">
                
                <div class="categories-title">
                  <h3>{{$categories_data->name}}</h3>
                </div>
              </a>
            </figure>

          </div>

    @endforeach
    </div>
  </div>
</div>
   @else
   <div class="general-product">
    <div class="container p-0">
      <div class="cat1-carousel-js">
        @foreach($result['commonContent']['categories'] as $categories_data)


      <div class="">
        <div class="cat-banner">
          <a href="{{ URL::to('/shop?category='.$categories_data->slug)}}">
          <figure class=" categories-icon">      
              <img class="img-fluid" src="{{asset('').$categories_data->iconPath}}" alt="{{$categories_data->name}}">       
          
              <h3>{{$categories_data->name}}</h3>
          </figure>
          </a>
          
        </div>
      </div>

      @endforeach
      </div>
    </div>
  </div>
  @endif
  </section>
  @endif