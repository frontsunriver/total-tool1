<!-- //banner one -->
<div class="banner-fourteen">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-fourteen-component :data="{{$data}}"></banner-fourteen-component>
        </div>
      </div>
</div>
