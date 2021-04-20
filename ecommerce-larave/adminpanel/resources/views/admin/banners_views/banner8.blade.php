<!-- //banner one -->
<div class="banner-eight">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-eight-component :data="{{$data}}"></banner-eight-component>
        </div>
      </div>
</div>
