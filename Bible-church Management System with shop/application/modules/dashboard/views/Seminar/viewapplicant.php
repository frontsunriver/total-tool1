<?php foreach ($individual as $row): ?>
    <div class="content user-profile">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card card-profile">
                        <div class="card-avatar">						
                            <img class="img" src="<?php echo base_url(); ?>assets/assets/images/<?php if($row->profileimage){ echo "seminar/profile/" . $row->profileimage; }else{ echo "avatar.png"; } ?>" alt="<?php echo $row->fname; ?>">
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="category text-gray"><?php echo $seminartitle; ?></h6>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="card-title"><?php echo $row->fname . " " . $row->lname; ?></h4>
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
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_gender'); ?>" ><i class="material-icons">person</i> <?php echo $row->gender; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_age'); ?>" ><i class="material-icons">date_range</i> <?php echo $row->age; ?> Years Old</p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_education'); ?>" ><i class="material-icons">school</i> <?php echo $row->education; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_church'); ?>" ><i class="material-icons">account_balance</i> <?php echo $row->church; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_pastor'); ?>" ><i class="material-icons">person</i> <?php echo $row->churchpastor; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_guardian'); ?>" ><i class="material-icons">person</i> <?php echo $row->guardian; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_guardian_phone'); ?>"><i class="material-icons">phone</i> <?php echo $row->guardiancontact; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_nationality'); ?>" ><i class="material-icons">flag</i> <?php echo $row->nationality; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_payment'); ?>" ><i class="material-icons">attach_money</i> <?php echo $row->paymentgateway; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_paymentinfo'); ?>"><i class="material-icons">assignment</i> <?php echo $row->paymentgatewayinfo; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_paymentsender'); ?>" ><i class="material-icons">assignment</i> <?php echo $row->paymentsenderinfo; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 address">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_address'); ?>"><i class="material-icons">map</i> <?php echo strip_tags($row->address); ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="action-btn">
                                    <a href="<?php echo base_url(); ?>dashboard/seminar/editapplicant/<?php echo $row->seminarregid; ?>" class="btn btn-warning btn-sm"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                    <a href="<?php echo base_url(); ?>dashboard/seminar/deleteapplicant/<?php echo $row->seminarregid; ?>" class="btn btn-danger btn-sm delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>