<!-- //banner one -->
<div class="banner-thirteen">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-thirteen-component :data="{{$data}}"></banner-thirteen-component>
        </div>
      </div>
</div>
