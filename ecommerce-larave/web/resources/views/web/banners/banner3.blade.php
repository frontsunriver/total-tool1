<!-- //banner three -->
<div class="banner-three">
          
  <div class="container">
      <div class="group-banners">
          <div class="row">
              <div class="col-12 col-md-4">
                @if(count($result['commonContent']['homeBanners'])>0)
                  @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                    @if($homeBanners->type==7)
                  <figure class="banner-image ">
                    <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                  </figure>
                  @endif
                  @endforeach
                @endif
                </div>
            <div class="col-12 col-md-8">
            
              <div class="row">
                <div class="col-12 col-md-6">
                  @if(count($result['commonContent']['homeBanners'])>0)
                      @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                        @if($homeBanners->type==8)
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
                     @if($homeBanners->type==9)
                 <figure class="banner-image ">
                   <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                 </figure>
                 @endif
                @endforeach
               @endif
                </div>
              </div>
              @if(count($result['commonContent']['homeBanners'])>0)
                   @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                      @if($homeBanners->type==6)
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
