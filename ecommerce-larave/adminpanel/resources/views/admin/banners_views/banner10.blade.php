<!-- //banner one -->
<div class="banner-ten">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-ten-component :data="{{$data}}"></banner-ten-component>
        </div>
      </div>
</div>
