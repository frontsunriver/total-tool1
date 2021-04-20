
<div class="wrapper_section shop-single">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/shop">Shop</a></p>
            <h2>Shop</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($product as $product): ?>
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <div class="seminar single product">
                        <?php if($product->image){ ?>
                            <img src="<?php echo base_url(); ?>assets/assets/images/product/photo/<?php echo $product->image; ?>" alt="<?php echo $product->title;?>"></img>
                        <?php }else{ ?>
                            <img src="<?php echo base_url(); ?>assets/assets/images/no-preview.png" alt="<?php echo $product->title;?>"></img>
                        <?php } ?>
                    </div>

                </div>

                <div class="col-md-5 product-sidebar">
                    <a  class="product-title" href="<?php echo base_url(); ?>home/shop/view/<?php echo $product->productID; ?>"><?php echo $product->title; ?></a>
                    <div class="indicators">
                        <span class="price"><?php echo getBasic()->currency; ?> <?php echo number_format($product->price, 0); ?></span>
                        <?php if($product->sale){ ?>
                            <span class="sale">Sale</span>
                        <?php } ?>
                    </div>
                    <div class="form">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>home/shop/addtocart" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="productID" value="<?php echo $product->productID; ?>">
                            <input type="hidden" name="price" value="<?php echo $product->price; ?>">
                            <input type="number" min="1" name="quantity" class="form-control quantity" placeholder="Quantity" value="1">
                            <button type="submit" class="btn btn-primary add-to-cart" ><i class="fa fa-shop"></i> Add To Cart</button>
                        </form>
                    </div>

                    <div class="elements">
                        <span>Categories : <?php echo $product->category; ?></span>
                    </div>
                </div>

            <?php endforeach; ?>

                <div class="col-md-12">

                    <div class="seminar-view">
                        <h4><?php echo $product->description; ?></h4>
                    </div>

                    <div class="separator-container">
                        <div class="extra_space_sm"></div>
                    </div>

                    <div class="#">
                        <div class="socialShare"></div>
                    </div>

                    <h2>Other Products</h2>
                    <div class="separator-container">
                        <div class="separator line-separator">♦</div>
                    </div>

                    <?php if( is_array($otherproducts) ){ ?>
                    <?php
                    $num = 1;
                    $breaker = 3; //Loop Break After 3 Cycle
                    foreach ($otherproducts as $otherp){
                    if ($num == 1){
                        echo '<div class="row">'; //First col, so open the row.
                    } ?>

                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="seminar product">
                            <span class="price"><?php echo getBasic()->currency; ?> <?php echo number_format($otherp->price, 0); ?></span>
                            <?php if($otherp->sale){ ?>
                                <span class="sale">Sale</span>
                            <?php } ?>

                            <?php if($otherp->image){ ?>
                                <img src="<?php echo base_url(); ?>assets/assets/images/product/photo/<?php echo $otherp->image; ?>" alt="<?php echo $otherp->title;?>"></img>
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/assets/images/no-preview.png" alt="<?php echo $otherp->title;?>"></img>
                            <?php } ?>

                            <h4><a   href="<?php echo base_url(); ?>home/shop/view/<?php echo $otherp->productID; ?>"><?php echo $otherp->title; ?></a></h4>
                            <h5><span>Category - <?php echo $otherp->category; ?></span></h5>
                        </div>
                    </div>
                    <?php
                        $num++;
                        if ($num > $breaker) {
                            echo '</div>';
                            $num = 1;
                        }
                    } ?> <?php } ?>
            </div>
        </div>
    </div>
</div>
