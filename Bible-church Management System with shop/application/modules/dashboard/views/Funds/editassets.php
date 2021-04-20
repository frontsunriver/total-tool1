<div class="content editassets">
    <div class="container">

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
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
                                <!-- <i class="material-icons">date_range</i> Last 24 Hours -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="green">
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
                                <!-- <i class="material-icons">date_range</i> Last 24 Hours -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="red">
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
                                <!-- <i class="material-icons">local_offer</i> Tracked from Github -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">	                    
            <div class="col-md-offset-0 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_updaterecord'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">

                        <?php foreach ($assets as $row): ?>
                            <form id="fund_add_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/financial/updateassets" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                            <input type="hidden" id="assetsid" name="assetsid" value="<?php echo $row->assetsid; ?>">

                                            <input type="text" id="assetsdate" name="assetsdate" class="datepicker form-control" value="<?php echo $row->assetsdate; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_aassets'); ?> (*)</label>
                                            <input type="text" id="assetsitem" name="assetsitem" class="form-control" value="<?php echo $row->assetsitem; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_aavalue'); ?> (*)</label>
                                            <input type="text" id="assetsamount" name="assetsamount" class="form-control" value="<?php echo $row->assetsamount; ?>" required>
                                        </div>
                                    </div>	

                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_verifier'); ?> (*)</label>
                                            <input type="text" id="assetsverifiedby" name="assetsverifiedby" class="form-control" value="<?php echo $row->assetsverifiedby; ?>" required>
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

                                <button type="submit" class="btn btn-primary pull-right"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_update_now'); ?></button>
                                <div class="clearfix"></div>
                            </form>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>