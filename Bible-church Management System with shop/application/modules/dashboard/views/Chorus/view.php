<?php foreach ($individual as $row): ?>
    <div class="content user-profile">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card card-profile">
                        <div class="card-avatar">						
                            <img class="img" src="<?php echo base_url(); ?>assets/assets/images/<?php
                            if ($row->profileimage) {
                                echo "chorus/profile/" . $row->profileimage;
                            } else {
                                echo "avatar.png";
                            }
                            ?>" alt="<?php echo $row->fname; ?>">

                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="category text-gray"><?php echo $row->position; ?></h6>
                                </div>

                                <div class="col-md-12">
                                    <h4 class="card-title"><?php echo $row->fname . $row->lname; ?></h4>
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
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_marriagedate'); ?>" ><i class="material-icons">date_range</i> <?php echo $row->marriagedate; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_socialstatus'); ?>" ><i class="material-icons">book</i> <?php echo $row->socialstatus; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_job'); ?>" ><i class="material-icons">work</i> <?php echo $row->job; ?></p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_family'); ?>" ><i class="material-icons">people</i> <?php echo $row->family; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray" title="<?php echo $this->lang->line('dash_gpanel_department'); ?>"><i class="material-icons">view_module</i> <?php echo $row->department; ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p class="category text-gray fr_view" title="<?php echo $this->lang->line('dash_gpanel_address'); ?>"><i class="material-icons">map</i> <?php echo strip_tags($row->address); ?></p>
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
                                <div class="action-btn">
                                    <a href="<?php echo base_url(); ?>dashboard/chorus/edit/<?php echo $row->chorusid; ?>" class="btn btn-warning btn-sm"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                    <a href="<?php echo base_url(); ?>dashboard/chorus/delete/<?php echo $row->chorusid; ?>" class="btn btn-danger btn-sm delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                </div>
                            </div>

                            <h3>Attendance Statistics</h3>
                            <hr>
                            
                            <div id="calendar"></div>
                            
                            <script>
                                $(document).ready(function() {
                                    
                                    $("#calendar").fullCalendar({
                                        header: {
                                            left: 'prev,next today',
                                            center: 'title',
                                            right: 'month, agendaWeek, agendaDay, listWeek'
                                        },
                                        defaultDate: new Date(),
                                        height: 500,
                                        displayEventTime: false,
                                        events: [
                                            <?php $i = 0; $totalevents = count($events); foreach ($events as $events) { $i++; ?>

                                            {

                                                title: '<?php echo $events->type; ?> | <?php echo $events->status; ?>',
                                                start: '<?php $edate = $events->time; echo date("Y-m-d", strtotime(str_replace("/", "-", $edate))); ?>'

                                            }

                                            <?php if ($i == $totalevents) { } else { echo ","; } ?> <?php } ?>
                                        ]
                                    });
                                
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>