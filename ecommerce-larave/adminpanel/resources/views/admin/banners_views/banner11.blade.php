<!-- //banner one -->
<div class="banner-elven">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-eleven-component :data="{{$data}}"></banner-eleven-component>
        </div>
      </div>
</div>
