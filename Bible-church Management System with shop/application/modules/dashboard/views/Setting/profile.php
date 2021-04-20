<?php foreach ($indiUser as $row): ?>
    <div class="content user-profile">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card card-profile">
                        <div class="card-avatar">						
                            <img class="img" src="<?php echo base_url(); ?>assets/assets/images/users/profile/<?php echo $row->profileimage; ?>" alt="<?php echo $row->fname; ?>">

                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="category text-gray"><?php echo $row->position; ?></h6>
                                </div>

                                <div class="col-md-12">
                                    <h4 class="card-title"><?php echo $row->fname . $row->lname; ?></h4>
                                </div>

                                <div class="col-md-12">
                                    <p class="description">
                                        <?php echo strip_tags($row->about); ?>
                                    </p>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_phone'); ?>" ><i class="material-icons">phone</i> <?php echo $row->phone; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_email'); ?>" ><i class="material-icons">email</i> <?php echo $row->email; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_position'); ?>" ><i class="material-icons">bookmark</i> <?php echo $row->position; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_bpdate'); ?>" ><i class="material-icons">date_range</i> <?php echo $row->bpdate; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_blood'); ?>" ><i class="material-icons">local_hospital</i> <?php echo $row->blood; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_dob'); ?>" ><i class="material-icons">date_range</i> <?php echo $row->dob; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_country'); ?>" ><i class="material-icons">place</i> <?php echo $row->country; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_city'); ?>" ><i class="material-icons">place</i> <?php echo $row->city; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_zone'); ?>"><i class="material-icons">place</i> <?php echo $row->postal; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 address">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_address'); ?>"><i class="material-icons">map</i> <?php echo strip_tags($row->address); ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="action-btn">
                                    <a href="<?php echo base_url(); ?>dashboard/setting/editprofile/<?php echo $row->userid; ?>" class="btn btn-warning btn-sm"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>