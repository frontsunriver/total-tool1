<?php foreach ($individual as $row): ?>
    <div class="content user-profile">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card card-profile">
                        
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="category text-gray">Department Leader : <?php echo $row->departmentleader; ?></h6>
                                </div>

                                <div class="col-md-12">
                                    <h4 class="card-title">Department Name : <?php echo $row->departmentname; ?></h4>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p class="category text-gray text-left" title="<?php echo $this->lang->line('dash_gpanel_phone'); ?>" ><i class="material-icons">phone</i> Contact Number : <?php echo $row->departmentcontact; ?></p>
                                    <p class="category text-gray text-left" title="<?php echo $this->lang->line('dash_gpanel_email'); ?>" ><i class="material-icons">email</i> Department Area/Zone : <?php echo $row->departmentarea; ?></p>
                                    <p class="category text-gray text-left" title="<?php echo $this->lang->line('dash_gpanel_country'); ?>" ><i class="material-icons">place</i> Country : <?php echo $row->country; ?></p>
                                    <p class="category text-gray text-left" title="<?php echo $this->lang->line('dash_gpanel_city'); ?>" ><i class="material-icons">place</i> City :  <?php echo $row->city; ?></p>
                                    <p class="category text-gray text-left" title="<?php echo $this->lang->line('dash_gpanel_zone'); ?>"><i class="material-icons">place</i> Postal/Zone : <?php echo $row->postal; ?></p>
                                    <p class="category text-gray text-left fr_view" title="<?php echo $this->lang->line('dash_gpanel_address'); ?>"><i class="material-icons">map</i> Description : <?php echo strip_tags($row->description); ?></p>
                                    <p class="category text-gray text-left fr_view" title="<?php echo $this->lang->line('dash_gpanel_address'); ?>"><i class="material-icons">map</i> Address : <?php echo strip_tags($row->address); ?></p>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="action-btn">
                                    <a href="<?php echo base_url(); ?>dashboard/department/edit/<?php echo $row->departmentid; ?>" class="btn btn-warning btn-sm"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                    <a href="<?php echo base_url(); ?>dashboard/department/delete/<?php echo $row->departmentid; ?>" class="btn btn-danger btn-sm delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>