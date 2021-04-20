@if(count($result['commonContent']['homepagebanners'])>0)
<div class="tri-banners-content pro-content">   
  @foreach(($result['commonContent']['homepagebanners']) as $homeBanners)  
    @if($homeBanners->banner_name=='banners_2')   
    <div class="fullwidth-banner" style="background-image: url('{{asset("").$homeBanners->image_path}}') ">
      <div class="parallax-banner-text">
        <?php 
          print stripslashes($homeBanners->text);
        ?>
      </div>
    </div> 
    @endif
   @endforeach         
</div>
@endif
