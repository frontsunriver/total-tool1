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
                        <form id="fund_add_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/financial/addnewassets" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                        <input type="text" id="assetsdate" name="assetsdate" class="datepicker form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_aassets'); ?> (*)</label>
                                        <input type="text" id="assetsitem" name="assetsitem" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_aavalue'); ?> (*)</label>
                                        <input type="text" id="assetsamount" name="assetsamount" class="form-control" required>
                                    </div>
                                </div>	

                                <div class="col-md-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_verifier'); ?> (*)</label>
                                        <input type="text" id="assetsverifiedby" name="assetsverifiedby" class="form-control" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row">	                                        
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rnote'); ?></label>
                                        <textarea type="text" rows="3" id="assetsnote" name="assetsnote" class="form-control"></textarea>
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

        <?php if ($assets) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_rrecords'); ?> <?php echo $this->lang->line('dash_allfunds_panel_title'); ?> ( <?php
                                $this->db->from('assets');
                                echo $this->db->count_all_results();
                                ?> )</h4>
                            <p class="category"><?php echo $this->lang->line('dash_gpanel_newrecord'); ?> <?php echo getCreateDate('assetsid','assets'); ?></p>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="dtAssets table table-hover">
                                <thead>
                                <th><?php echo $this->lang->line('dash_gpanel_sl'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_date'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_aassets'); ?></th>												
                                <th><?php echo $this->lang->line('dash_gpanel_aavalue'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_note'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                                </thead>
                                <tbody>

                                    <?php
                                    $i = 0;
                                    foreach ($assets as $row) {
                                        $i++;
                                        ?>

                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->assetsdate; ?></td>
                                            <td><?php echo $row->assetsitem; ?></td>
                                            <td><?php
                                                echo globalCurrency();
                                                echo number_format($row->assetsamount, 2);
                                                ?></td>	
                                            <td><?php
                                                $assetsnote = $row->assetsnote;
                                                echo word_limiter($assetsnote, 3);
                                                ?></td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>dashboard/financial/editassets/<?php echo $row->assetsid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                                <a href="<?php echo base_url(); ?>dashboard/financial/deleteassets/<?php echo $row->assetsid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                    <tr>

                                        <td><b></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_total'); ?></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_aavalue'); ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($sum_assets, 2);
                                                ?></b></td>
                                        <td><b></b></td>
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