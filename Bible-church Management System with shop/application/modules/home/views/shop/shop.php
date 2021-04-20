
<div class="wrapper_section shop">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allevent">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/Shop">Shop</a></p>
            <h2>Shop</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <?php             
            $num = 1;
            $breaker = 3; //Loop Break After 3 Cycle	        
            foreach ($product as $product){
            if ($num == 1){
                echo '<div class="row">'; //First col, so open the row.
            } ?>
            
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="seminar product">
                    <span class="price"><?php echo getBasic()->currency; ?> <?php echo number_format($product->price, 0); ?></span>
                    <?php if($product->sale){ ?>
                        <span class="sale">Sale</span>
                    <?php } ?>
                    
                    <?php if($product->image){ ?>
                        <img src="<?php echo base_url(); ?>assets/assets/images/product/photo/<?php echo $product->image; ?>" alt="<?php echo $product->title;?>"></img>
                    <?php }else{ ?>
                        <img src="<?php echo base_url(); ?>assets/assets/images/no-preview.png" alt="<?php echo $product->title;?>"></img>
                    <?php } ?>
                        
                    <h4><a   href="<?php echo base_url(); ?>home/shop/view/<?php echo $product->productID; ?>"><?php echo $product->title; ?></a></h4>      
                    <h5><span>Category - <?php echo $product->category; ?></span></h5>
                    
                </div>
            </div>
            <?php             
                $num++;
                if ($num > $breaker) {
                    echo '</div>';
                    $num = 1;
                }
            } 
            
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div> 
        </div>
    </div>
</div> 




