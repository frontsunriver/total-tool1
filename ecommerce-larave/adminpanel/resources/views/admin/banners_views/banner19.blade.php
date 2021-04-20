<!-- //banner one -->
<div class="banner-nineteen">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-nineteen-component :data="{{$data}}"></banner-nineteen-component>
        </div>
      </div>
</div>
