
<div class="content allproducts gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">
                            <?php echo $this->lang->line('dash_allorders_panel_title'); ?>
                            ( <?php
                            $this->db->from('orders');
                            $this->db->where('orderUserID', $this->session->userdata('user_id'));
                            echo $this->db->count_all_results();
                            ?> ) 
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
                                if ($this->uri->segment(5)) {
                                    $i = $this->uri->segment(5);
                                } else {
                                    $i = "";
                                }
                                foreach ($orders as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>                                        
                                        <td><?php echo ucfirst(getUserByID($row->orderUserID)->username); ?></td>
                                        <td><?php 
                                        
                                        $cartIDs = explode(',', $row->orderCartIDs); 
                                        for($x=0; count($cartIDs) > $x; $x++){
                                            if(!empty($cartIDs[$x])){
                                                echo getProductByCartID($cartIDs[$x])->title . " (" . getProductByCartID($cartIDs[$x])->quantity .  " x $" . getProductByCartID($cartIDs[$x])->price . "), ";
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
                                            <?php } ?>
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