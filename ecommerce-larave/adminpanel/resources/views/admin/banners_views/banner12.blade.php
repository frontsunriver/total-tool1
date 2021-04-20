<!-- //banner one -->
<div class="banner-twelve">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-twelve-component :data="{{$data}}"></banner-twelve-component>
        </div>
      </div>
</div>
