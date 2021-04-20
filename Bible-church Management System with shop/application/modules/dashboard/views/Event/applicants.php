<div class="content gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-md-offset-2 xxxcol-md-8">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">search</i> <?php echo $this->lang->line('dash_gpanel_bapplicants'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">

                        <form id="pastor_add_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/event/applicantslist" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_eventtitle'); ?> (*)</label>
                                        <select name="eventid" class="select form-control">
                                            <?php foreach ($events as $event) { ?>
                                                <option value="<?php echo $event->eventid; ?>">
                                                    <?php echo word_limiter($event->eventtitle, 6);?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <button id="website_user_submit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">search</i> <?php echo $this->lang->line('dash_gpanel_bapplicants'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($applicants) && !empty($applicants)) { ?>
            <div class="xxxrow">
                <div class="xxxcol-lg-12 xxxcol-md-12 gusers">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title"><i class="material-icons">people</i> <?php echo $this->lang->line('dash_gpanel_applicantslist'); ?> | <strong><?php echo $current_event; ?></strong> </h4>
                            <p class="category"><?php echo $this->lang->line('dash_gpanel_newapplicant'); ?> <?php echo getCreateDate('registrationID','eventregistration'); ?></p>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="dtApplicants display table table-hover" cellspacing="0" width="100%">
                                <thead>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Action</th>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($this->uri->segment(4)) {
                                        $i = $this->uri->segment(4);
                                    } else {
                                        $i = "";
                                    }
                                    foreach ($applicants as $row) {
                                        $i++;
                                        ?>

                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->fname . " " . $row->lname; ?></td>
                                            <td><?php echo $row->gender; ?></td>
                                            <td><?php echo $row->phone; ?></td>
                                            <td><?php echo $row->address; ?></td>
                                            <td><?php echo $row->city; ?></td>
                                            <td><?php echo $row->country; ?></td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>dashboard/event/viewapplicant/<?php echo $row->registrationID; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                                <a href="<?php echo base_url(); ?>dashboard/event/editapplicant/<?php echo $row->registrationID; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                                <a href="<?php echo base_url(); ?>dashboard/event/deleteapplicant/<?php echo $row->registrationID; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
