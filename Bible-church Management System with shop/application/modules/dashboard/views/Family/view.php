<?php foreach ($individual as $row): ?>
    <div class="content user-profile">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card card-profile">
                        
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="category text-gray">Family Leader : <?php echo $row->familyleader; ?></h6>
                                </div>

                                <div class="col-md-12">
                                    <h4 class="card-title">Family Name : <?php echo $row->familyname; ?></h4>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_phone'); ?>" ><i class="material-icons">phone</i> Contact Number : <?php echo $row->familycontact; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_email'); ?>" ><i class="material-icons">email</i> Member Quantity : <?php echo $row->memberquantity; ?></p>
                                </div>
                            </div>  
                            
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_country'); ?>" ><i class="material-icons">place</i> Country : <?php echo $row->country; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_city'); ?>" ><i class="material-icons">place</i> City :  <?php echo $row->city; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_zone'); ?>"><i class="material-icons">place</i> Postal/Zone : <?php echo $row->postal; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 address">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_address'); ?>"><i class="material-icons">map</i> Address : <?php echo strip_tags($row->address); ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="action-btn">
                                    <a href="<?php echo base_url(); ?>dashboard/family/edit/<?php echo $row->familyid; ?>" class="btn btn-warning btn-sm"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                    <a href="<?php echo base_url(); ?>dashboard/family/delete/<?php echo $row->familyid; ?>" class="btn btn-danger btn-sm delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>