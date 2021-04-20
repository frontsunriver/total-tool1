<!-- //banner one -->
<div class="banner-one">
    <div class="container">
      <div class="group-banners">
          <div class="row">
            @if(count($result['commonContent']['homeBanners'])>0)
             @foreach(($result['commonContent']['homeBanners']) as $homeBanners)
                @if($homeBanners->type==3 or $homeBanners->type==4 or $homeBanners->type==5)
                <div class="col-12 col-md-4">
                  <figure class="banner-image ">
                    <a href="{{ $homeBanners->banners_url}}"><img class="img-fluid" src="{{asset('').$homeBanners->path}}" alt="Banner Image"></a>
                  </figure>
                </div>
              @endif
             @endforeach
            @endif
          </div>
        </div>
    </div>
</div>


