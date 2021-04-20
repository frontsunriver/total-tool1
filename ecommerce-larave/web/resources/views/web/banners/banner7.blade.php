<!-- //banner seven -->
 <div class="banner-seven">

      <div class="container">
          <div class="group-banners">
              <div class="row">
                <div class="col-12 col-md-6">
                  @if(count($result['commonContent']['homeBanners'])>0)
                   @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                      @if($homeBanners->type==15)
                  <figure class="banner-image ">
                    <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                  </figure>
                  @endif
                 @endforeach
                @endif
                </div>
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-md-6">
                          @if(count($result['commonContent']['homeBanners'])>0)
                           @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                              @if($homeBanners->type==16)
                            <figure class="banner-image ">
                              <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                            </figure>
                            @endif
                           @endforeach
                          @endif
                          </div>
                      <div class="col-12 col-md-6">
                        @if(count($result['commonContent']['homeBanners'])>0)
                         @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                            @if($homeBanners->type==17)
                        <figure class="banner-image ">
                          <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                        </figure>
                        @endif
                       @endforeach
                      @endif
                      </div>
                      <div class="col-12">
                        @if(count($result['commonContent']['homeBanners'])>0)
                         @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                            @if($homeBanners->type==18)
                        <figure class="banner-image " style="margin-top: 30px;">
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
      </div>
</div>
