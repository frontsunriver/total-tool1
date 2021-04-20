<div class="wrapper_section cart-page">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large" data-anim-delay="300">
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/shop">Shop</a></p>
            <h2>Cart</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-hover">
                    <thead>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $totalPrice = array();
                        $cartIDs = array();
                        foreach ($carts as $product) : ?>
                            <tr>
                                <?php if ($product->image) { ?>
                                    <td><img class="product-image" src="<?php echo base_url(); ?>assets/assets/images/product/photo/<?php echo $product->image; ?>" alt="<?php echo $product->title; ?>"></td>
                                <?php } else { ?>
                                    <td><img class="product-image" src="<?php echo base_url(); ?>assets/assets/images/thumb.jpg" alt=""></td>
                                <?php } ?>
                                <td><?php echo $product->title; ?></td>
                                <td><?php echo getBasic()->currency; ?> <?php echo number_format($product->price, 2); ?></td>
                                <td><?php echo $product->quantity; ?></td>
                                <td><?php echo getBasic()->currency; ?> <?php echo number_format($product->price * $product->quantity, 2); ?></td>
                                <td><a href="<?php echo base_url(); ?>home/shop/cancelcart/<?php echo $product->cartID; ?>"><button class="btn btn-danger">X</button></a></td>
                            </tr>
                            <?php
                            $totalPrice[] = $product->price * $product->quantity;
                            $cartIDs[] = $product->cartID;

                            ?>
                        <?php endforeach; ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>Total : <?php echo getBasic()->currency; ?> <?php echo number_format(array_sum($totalPrice), 2); ?></b></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-offset-10 col-md-2">
                    <button data-toggle="modal" data-target="#checkoutModal" class="btn btn-success checkout-btn">Checkout Now</button>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="donationModalLabel"><i class="fa fa-shopping-bag"></i> Checkout</h3>
                        </div>
                        <div class="modal-body">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title text-center">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Paypal
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="<?php echo base_url(); ?>home/shop/paypal/" method="post" enctype="multipart/form-data">                                                        
                                                        <input type="hidden" name="cartIDs" value="<?php json_encode($cartIDs); ?>">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="name" placeholder="Your Name *" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="phone" placeholder="Your Phone *" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <textarea rows="3" class="form-control" name="address" required>Your Address (*)</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-offset-4 col-md-6">
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-bag"></i> Checkout By Paypal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title text-center">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Stripe
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="<?php echo base_url(); ?>home/shop/stripe/" method="post" class="stripe-form" id="payment-form" enctype="multipart/form-data">                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="name" placeholder="Your Name *" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="phone" placeholder="Your Phone *" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <textarea rows="3" class="form-control" name="address" required>Your Address (*)</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p for="card-element">Credit or Debit Card</p>
                                                            <div id="card-element">
                                                                <!-- a Stripe Element will be inserted here. -->
                                                            </div>
                                                            <!-- Used to display form errors -->
                                                            <div id="card-errors"></div>
                                                        </div>
                                                        <div class="col-md-offset-4 col-md-6">
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-bag"></i> Checkout By Stripe</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title text-center">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Paystack
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="<?php echo base_url(); ?>home/shop/paystack/" method="post" class="paystack-form" id="payment-form" enctype="multipart/form-data">                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="name" placeholder="Your Name *" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="phone" placeholder="Your Phone *" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <textarea rows="3" class="form-control" name="address" required>Your Address (*)</textarea>
                                                            </div>
                                                        </div>                                                        
                                                        <div class="col-md-offset-4 col-md-6">
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-bag"></i> Checkout By Paystack</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h2>Other Products</h2>
                <div class="separator-container">
                    <div class="separator line-separator">♦</div>
                </div>
                <?php
                $num = 1;
                $breaker = 3; //Loop Break After 3 Cycle
                foreach ($otherproducts as $otherp) {
                    if ($num == 1) {
                        echo '<div class="row">'; //First col, so open the row.
                    } ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="seminar product">
                            <span class="price"><?php echo getBasic()->currency; ?> <?php echo number_format($otherp->price, 0); ?></span>
                            <?php if ($otherp->sale) { ?>
                                <span class="sale">Sale</span>
                            <?php } ?>
                            <?php if ($otherp->image) { ?>
                                <img src="<?php echo base_url(); ?>assets/assets/images/product/photo/<?php echo $otherp->image; ?>" alt="<?php echo $otherp->title; ?>"></img>
                            <?php } else { ?>
                                <img src="<?php echo base_url(); ?>assets/assets/images/no-preview.png" alt="<?php echo $otherp->title; ?>"></img>
                            <?php } ?>
                            <h4><a href="<?php echo base_url(); ?>home/shop/view/<?php echo $otherp->productID; ?>"><?php echo $otherp->title; ?></a></h4>
                            <h5><span>Category - <?php echo $otherp->category; ?></span></h5>
                        </div>
                    </div>
                <?php
                    $num++;
                    if ($num > $breaker) {
                        echo '</div>';
                        $num = 1;
                    }
                } ?>
            </div>
        </div>
    </div>
</div>