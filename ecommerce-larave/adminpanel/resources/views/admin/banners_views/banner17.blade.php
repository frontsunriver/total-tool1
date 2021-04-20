<!-- //banner one -->
<div class="banner-seventeen">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-seventeen-component :data="{{$data}}"></banner-seventeen-component>
        </div>
      </div>
</div>
