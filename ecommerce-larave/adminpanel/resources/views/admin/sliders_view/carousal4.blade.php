<!-- //banner one -->
<div class="banner-one">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <carousel4-slider-component :data="{{$data}}"></carousel4-slider-component>
        </div>
      </div>
</div>
