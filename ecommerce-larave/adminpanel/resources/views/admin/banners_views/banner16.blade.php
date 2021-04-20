<!-- //banner one -->
<div class="banner-sixteen">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-sixteen-component :data="{{$data}}"></banner-sixteen-component>
        </div>
      </div>
</div>
