<!-- //banner one -->
<div class="banner-two">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-two-component :data="{{$data}}"></banner-two-component>
        </div>
      </div>
</div>
