<!-- //banner one -->
<div class="banner-fifteen">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-fifteen-component :data="{{$data}}"></banner-fifteen-component>
        </div>
      </div>
</div>
