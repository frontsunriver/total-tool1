@extends('web.layout')
@section('content')
       <!-- End Header Content -->

       <!-- NOTIFICATION CONTENT -->
         @include('web.common.notifications')
      <!-- END NOTIFICATION CONTENT -->

       <!-- Carousel Content -->
       <?php  echo $final_theme['carousel']; ?>
       <!-- Fixed Carousel Content -->

      <!-- Banners Content -->
      <!-- Products content -->

      <?php

      $product_section_orders = json_decode($final_theme['product_section_order'], true);
      foreach ($product_section_orders as $product_section_order){
          if($product_section_order['status'] == 1)
          {
            //echo $product_section_order['file_name'].'<br>';
            $r =   'web.product-sections.' . $product_section_order['file_name'];
      
      ?>
            @include($r)
      
      <?php

          }
       }
      
      ?>
@include('web.common.scripts.addToCompare')
@include('web.common.scripts.Like')
@endsection
