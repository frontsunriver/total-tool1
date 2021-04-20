<!-- //banner sixteen -->
 <div class="banner-sixteen">

      <div class="container">
          <div class="group-banners">
              <div class="row">
                <div class="col-12 col-md-8">
                  @if(count($result['commonContent']['homeBanners'])>0)
                   @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                      @if($homeBanners->type==30)
                <figure class="banner-image " style="margin-bottom: 30px;">
                    <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                  </figure>
                  @endif
                 @endforeach
                @endif
                @if(count($result['commonContent']['homeBanners'])>0)
                 @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                    @if($homeBanners->type==31)
                  <figure class="banner-image ">
                      <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                    </figure>
                    @endif
                   @endforeach
                  @endif
                </div>
                <div class="col-12 col-md-4">
                  @if(count($result['commonContent']['homeBanners'])>0)
                   @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                      @if($homeBanners->type==32)
                    <figure class="banner-image">
                      <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                    </figure>
                    @endif
                   @endforeach
                  @endif
                </div>
              </div>
          </div>
      </div>

</div>
