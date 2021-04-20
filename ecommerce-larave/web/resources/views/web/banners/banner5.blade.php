<!-- //banner five -->
<div class="banner-five">

      <div class="container">
          <div class="group-banners">
              <div class="row">
                  <div class="col-12 col-md-6">
                      <div class="row">
                        <div class="col-12 col-md-6">
                          @if(count($result['commonContent']['homeBanners'])>0)
                           @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                              @if($homeBanners->type==10)
                          <figure class="banner-image imagespace">
                            <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                          </figure>
                          @endif
                         @endforeach
                        @endif
                        </div>
                        <div class="col-12 col-md-6">
                          @if(count($result['commonContent']['homeBanners'])>0)
                           @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                              @if($homeBanners->type==11)
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
                              @if($homeBanners->type==12)
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
                                @if($homeBanners->type==13)
                              <figure class="banner-image ">
                                <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                              </figure>
                              @endif
                             @endforeach
                            @endif
                            </div>
                      </div>
                    </div>
                  <div class="col-12 col-md-6">
                    @if(count($result['commonContent']['homeBanners'])>0)
                     @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                        @if($homeBanners->type==14)
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