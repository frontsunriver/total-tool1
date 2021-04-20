<!-- //banner one -->
<div class="banner-six">
      <div class="container">
        <div class="group-banners" id="app">
          <?php  $data = json_encode($result); ?>
          <banner-six-component :data="{{$data}}"></banner-six-component>
        </div>
      </div>
</div>
