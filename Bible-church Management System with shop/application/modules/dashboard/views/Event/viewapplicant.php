<?php foreach ($individual as $row): ?>
    <div class="content user-profile">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card card-profile">

                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="category text-gray"><?php echo $eventtitle; ?></h6>
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
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_age'); ?>" ><i class="material-icons">date_range</i> <?php echo $row->birthdate; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_nationality'); ?>" ><i class="material-icons">flag</i> <?php echo $row->nationality; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 address">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_address'); ?>"><i class="material-icons">map</i> <?php echo strip_tags($row->address); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_city'); ?>" ><i class="material-icons">map</i> <?php echo $row->city; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_country'); ?>" ><i class="material-icons">map</i> <?php echo $row->country; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_postal'); ?>"><i class="material-icons">map</i> <?php echo $row->postal; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_hotel'); ?>"><i class="material-icons">domain</i> <?php echo $row->hotel; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_room'); ?>"><i class="material-icons">local_dining</i> <?php echo $row->room; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_seat'); ?>"><i class="material-icons">airline_seat_recline_extra</i> <?php echo $row->seat; ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_bus'); ?>"><i class="material-icons">directions_bus</i> <?php echo $row->bus; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_badge'); ?>"><i class="material-icons">brightness_5</i> <?php echo $row->badge; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_confirmation'); ?>"><i class="material-icons">confirmation_number</i> <?php echo $row->confirmation; ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="action-btn">
                                    <a href="<?php echo base_url(); ?>dashboard/event/editapplicant/<?php echo $row->registrationID; ?>" class="btn btn-warning btn-sm"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                    <a href="<?php echo base_url(); ?>dashboard/event/deleteapplicant/<?php echo $row->registrationID; ?>" class="btn btn-danger btn-sm delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>
