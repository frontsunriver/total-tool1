<!-- Bootstrap Carousel Content with Left Banner -->
 <section class="carousel-content" style="margin-top: 30px;">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-4 d-none d-lg-block d-xl-block"> 
            <div class="group-banners">
              @if(count($result['commonContent']['homeBanners'])>0)
                    @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                        @if($homeBanners->type==1 or $homeBanners->type==2)
                        <figure class="banner-image imagespace">
                          <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                        </figure>
                        @endif
                    @endforeach
                @endif 
            </div>
        </div>
        <div class="col-12 col-lg-8">
          <div id="carouselExampleIndicators4" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              @foreach($result['slides'] as $key=>$slides_data)
                <li data-target="#carouselExampleIndicators4" data-slide-to="{{ $key }}" class="@if($key==0) active @endif"></li>
              @endforeach
            </ol>
            <div class="carousel-inner">

              @foreach($result['slides'] as $key=>$slides_data)
                  <div class="carousel-item  @if($key==0) active @endif">
                  @if($slides_data->type == 'category')
                    <a href="{{ URL::to('/shop?category='.$slides_data->url)}}">
                  @elseif($slides_data->type == 'product')
                    <a href="{{ URL::to('/product-detail/'.$slides_data->url)}}">
                  @elseif($slides_data->type == 'mostliked')
                    <a href="{{ URL::to('shop?type=mostliked')}}">
                  @elseif($slides_data->type == 'topseller')
                    <a href="{{ URL::to('shop?type=topseller')}}">
                  @elseif($slides_data->type == 'deals')
                    <a href="{{ URL::to('shop?type=deals')}}">
                  @endif
                    <img class="d-block w-100"  src="{{asset('').$slides_data->path}}" width="100%" alt="First slide">
                  </a>
                  </div>
              @endforeach

            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators4" role="button" data-slide="prev">            
              <span class="sr-only">@lang('website.Previous')</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators4" role="button" data-slide="next">          
              <span class="sr-only">@lang('website.Next')</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
