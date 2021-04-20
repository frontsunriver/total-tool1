<!-- //banner one -->
<div class="banner-seven">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-seven-component :data="{{$data}}"></banner-seven-component>
        </div>
      </div>
</div>
