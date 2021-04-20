<!-- //banner one -->
<div class="banner-four">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-four-component :data="{{$data}}"></banner-four-component>
        </div>
      </div>
</div>
