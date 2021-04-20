
<div class="content allproducts gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">
                            <?php echo $this->lang->line('dash_allorders_panel_title'); ?>
                            ( <?php echo count($orders); ?> )
                        </h4>
                        <p class="category">-</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtUser gusers table table-hover">
                            <thead class="text-default">
                            <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_username'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_product'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_amount'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_paymentmethod'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_paymentinfo'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_status'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_address'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($orders as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <?php if(getUserByID($row->orderUserID) !=false){ ?>
                                            <td><?php echo ucfirst(getUserByID($row->orderUserID)->username); ?></td>
                                        <?php }else{ ?>
                                            <td>N/A</td>
                                        <?php } ?>

                                        <td><?php

                                        $cartIDs = explode(',', $row->orderCartIDs);
                                        for($x=0; count($cartIDs) > $x; $x++){
                                            if(!empty($cartIDs[$x]) && getProductByCartID($cartIDs[$x]) !=false ){
                                                echo getProductByCartID($cartIDs[$x])->title . " (" . getProductByCartID($cartIDs[$x])->quantity .  " x $" . getProductByCartID($cartIDs[$x])->price . "), ";
                                            }else{
                                                echo " (N/A) ";
                                            }
                                        }

                                        ?></td>
                                        <td><?php echo $row->orderAmount; ?></td>
                                        <td><?php echo $row->orderMethod; ?></td>
                                        <td><?php echo $row->orderPayment; ?></td>
                                        <td><?php if(!empty($row->orderPayment)){ echo "Paid"; }; ?></td>
                                        <td><?php echo $row->orderAddress; ?></td>
                                        <td>
                                            <?php if($row->orderDeliver == "Delivered"){ ?>
                                                <a href="#" class="btn btn-success"><i class="material-icons">check</i> <?php echo $this->lang->line('dash_gpanel_delivered'); ?></a>
                                            <?php }else{ ?>
                                                <a href="<?php echo base_url(); ?>dashboard/shop/delivered/<?php echo $row->orderID; ?>" class="btn btn-warning"><i class="material-icons">check</i> <?php echo $this->lang->line('dash_gpanel_markdelivered'); ?></a>
                                            <?php }; ?>
                                            <a href="<?php echo base_url(); ?>dashboard/shop/deleteorder/<?php echo $row->orderID; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
