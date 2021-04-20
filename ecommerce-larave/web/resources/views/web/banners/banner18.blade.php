<!-- //banner eighteen -->
<div class="banner-eighteen">

      <div class="container">
          <div class="group-banners">
              <div class="row">
                <div class="col-12 col-md-5">
                  @if(count($result['commonContent']['homeBanners'])>0)
                   @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                      @if($homeBanners->type==33)
                  <figure class="banner-image imagespace">
                    <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                  </figure>
                  @endif
                 @endforeach
                @endif
                @if(count($result['commonContent']['homeBanners'])>0)
                 @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                    @if($homeBanners->type==34)
                  <figure class="banner-image ">
                      <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                    </figure>
                    @endif
                   @endforeach
                  @endif
                </div>
                <div class="col-12 col-md-3">
                  @if(count($result['commonContent']['homeBanners'])>0)
                   @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                      @if($homeBanners->type==35)
                  <figure class="banner-image imagespace">
                    <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                  </figure>
                  @endif
                 @endforeach
                @endif
                @if(count($result['commonContent']['homeBanners'])>0)
                 @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                    @if($homeBanners->type==36)
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
                      @if($homeBanners->type==37)
                    <figure class="banner-image imagespace">
                      <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                    </figure>
                    @endif
                   @endforeach
                  @endif
                  @if(count($result['commonContent']['homeBanners'])>0)
                   @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                      @if($homeBanners->type==38)
                    <figure class="banner-image ">
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
