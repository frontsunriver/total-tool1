<div class="content gusers">
    <div class="container">

<!--        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_totalcollect'); ?></p>
                        <h3 class="title"><?php
                            echo globalCurrency();
                            echo number_format($sum_collect, 2);
                            ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                                 <i class="material-icons">date_range</i> Last 24 Hours 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="green">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_totalspend'); ?></p>
                        <h3 class="title"><?php
                            echo globalCurrency();
                            echo number_format($sum_spend, 2);
                            ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                                 <i class="material-icons">date_range</i> Last 24 Hours 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="red">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_totalbalance'); ?></p>
                        <h3 class="title"><?php
                            echo globalCurrency();
                            echo number_format($sum_collect - $sum_spend, 2);
                            ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                                 <i class="material-icons">local_offer</i> Tracked from Github 
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

        <div class="row">	                    
            <div class="col-md-offset-0 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_addnewrecord'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="fund_add_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/financial/addnewdonation" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                        <input type="text" id="donationdate" name="donationdate" class="datepicker form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_amount'); ?> (*)</label>
                                        <input type="text" id="donationamount" name="donationamount" class="form-control" required>
                                    </div>
                                </div>	

                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rsource'); ?> (*)</label>
                                        <input type="text" id="donationsource" name="donationsource" class="form-control" required>
                                    </div>
                                </div>	

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_dby'); ?> (*)</label>
                                        <input type="text" id="donationby" name="donationby" class="form-control" required>
                                    </div>
                                </div>	

                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_dbyinfo'); ?> (*)</label>
                                        <input type="text" id="donationinfo" name="donationinfo" class="form-control">
                                    </div>
                                </div>	

                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_verifier'); ?> (*)</label>
                                        <input type="text" id="donationreceivedby" name="donationreceivedby" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">	                                        
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rnote'); ?></label>
                                        <textarea type="text" rows="3" id="donationnote" name="donationnote" class="form-control"></textarea>
                                    </div>
                                </div>	                                        
                            </div>

                            <button type="submit" class="btn btn-primary pull-right"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_add_now'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <?php if ($donations) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_rrecords'); ?> ( <?php
                                $this->db->from('donation');
                                echo $this->db->count_all_results();
                                ?> )</h4>
                            <p class="category"><?php echo $this->lang->line('dash_gpanel_newrecord'); ?> <?php echo getCreateDate('donationid','donation'); ?></p>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="dtDonation table table-hover">
                                <thead>
                                <th><?php echo $this->lang->line('dash_gpanel_sl'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_date'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_amount'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_rsource'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_dby'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_dbyinfo'); ?></th>
<!--                                <th><?php echo $this->lang->line('dash_gpanel_note'); ?></th>-->
                                <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                                </thead>
                                <tbody>

                                    <?php
                                    $i = 0;
                                    foreach ($donations as $row) {
                                        $i++;
                                        ?>

                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->donationdate; ?></td>
                                            <td><?php
                                                echo globalCurrency();
                                                echo number_format($row->donationamount, 2);
                                                ?></td>
                                            <td><?php echo $row->donationsource; ?></td>
                                            <td><?php echo $row->donationby; ?></td>
                                            <td><?php echo $row->donationinfo; ?></td>
<!--                                            <td title="<?php echo strip_tags($row->donationnote); ?>"><?php
                                                $donationnote = $row->donationnote;
                                                echo word_limiter($donationnote, 3);
                                                ?></td>-->
                                            <td>
                                                <a href="<?php echo base_url(); ?>dashboard/financial/editdonation/<?php echo $row->donationid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                                <a href="<?php echo base_url(); ?>dashboard/financial/deletedonation/<?php echo $row->donationid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                    <tr>

                                        <td><b><?php echo $this->lang->line('dash_gpanel_total'); ?></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_collect'); ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($sum_donation, 2);
                                                ?></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>



    </div>
</div>