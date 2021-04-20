<!-- //banner one -->
<div class="banner-eighteen">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-eighteen-component :data="{{$data}}"></banner-eighteen-component>
        </div>
      </div>
</div>
