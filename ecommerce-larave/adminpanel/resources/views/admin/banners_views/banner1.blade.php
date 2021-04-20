<!-- //banner one -->
<div class="banner-one">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-one-component :data="{{$data}}"></banner-one-component>
        </div>
      </div>
</div>
