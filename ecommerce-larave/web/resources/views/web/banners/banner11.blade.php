<!-- //banner eleven -->
<div class="banner-eleven">

      <div class="container">
          <div class="group-banners">
              <div class="row">
                  <div class="col-12 col-md-3">
                    @if(count($result['commonContent']['homeBanners'])>0)
                     @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                        @if($homeBanners->type==24)
                      <figure class="banner-image">
                        <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                      </figure>
                      @endif
                     @endforeach
                    @endif
                    </div>
                  <div class="col-12 col-md-6">
                    @if(count($result['commonContent']['homeBanners'])>0)
                     @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                        @if($homeBanners->type==21)
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
                      @if($homeBanners->type==22)
                        <figure class="banner-image imagespace">
                            <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                          </figure>
                          @endif
                         @endforeach
                        @endif
                        @if(count($result['commonContent']['homeBanners'])>0)
                         @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                            @if($homeBanners->type==23)
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
