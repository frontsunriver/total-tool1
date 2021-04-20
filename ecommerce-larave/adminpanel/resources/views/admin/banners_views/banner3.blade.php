<!-- //banner one -->
<div class="banner-three">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-three-component :data="{{$data}}"></banner-three-component>
        </div>
      </div>
</div>
