<!-- //banner one -->
<div class="banner-one">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <carousal-banner-component :data="{{$data}}"></carousal-banner-component>
        </div>
      </div>
</div>
