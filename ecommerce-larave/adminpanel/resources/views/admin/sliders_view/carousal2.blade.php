<!-- //banner one -->
<div class="banner-one">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <carousel2-slider-component :data="{{$data}}"></carousel2-slider-component>
        </div>
      </div>
</div>
