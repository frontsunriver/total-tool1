<!-- //banner one -->
<div class="banner-nine">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-nine-component :data="{{$data}}"></banner-nine-component>
        </div>
      </div>
</div>
