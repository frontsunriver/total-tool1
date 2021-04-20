<!-- //banner one -->
<div class="banner-five">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-five-component :data="{{$data}}"></banner-five-component>
        </div>
      </div>
</div>
