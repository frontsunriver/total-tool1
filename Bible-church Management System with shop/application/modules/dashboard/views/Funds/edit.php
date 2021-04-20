<div class="content editrecord">
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

        <?php if ($funds) { ?>
            <div class="xxxrow">	                    
                <div class="xxxcol-md-offset-0 xxxcol-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_updaterecord'); ?></h4>
                            <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                        </div>
                        <div class="card-content">

                            <?php foreach ($funds as $row): ?>

                                <form id="fund_add_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/financial/update" method="post" enctype="multipart/form-data">

                                    <input type="hidden" id="fundsid" name="fundsid" value="<?php echo $row->fundsid; ?>">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                                <input type="text" id="fdate" name="fdate" class="datepicker form-control" value="<?php echo $row->fundsdate; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_amount'); ?> (*)</label>
                                                <input type="text" id="amount" name="amount" class="form-control" value="<?php echo $row->fundsamount; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rtype'); ?> (*)</label>				
                                                <select id="amounttype" name="amounttype" class="select form-control" required>
                                                    <option value="">Select Type</option>
                                                    <option selected value="<?php echo $row->fundstype; ?>"><?php echo $row->fundstype; ?> (Current)</option>
                                                    <option value="Collect">Collect</option>
                                                    <option value="Spend">Spend</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">	                                        
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_verifier'); ?> (*)</label>
                                                <input type="text" id="receivedby" name="receivedby" class="form-control" value="<?php echo $row->receivedby; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rsource'); ?></label>
                                                <input type="text" id="source" name="source" class="form-control" value="<?php echo $row->fundssource; ?>">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">	                                        
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rnote'); ?></label>
                                                <textarea type="text" rows="3" id="description" name="description" class="form-control" value="<?php echo $row->fundsnote; ?>"></textarea>
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
        <?php } ?>


    </div>
</div>