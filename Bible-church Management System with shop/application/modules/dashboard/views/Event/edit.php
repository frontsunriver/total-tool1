<div class="content gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_updateevent_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <?php foreach ($individual as $row): ?>
                            <form id="updateEventForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/event/updateevent" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-offset-0 col-md-12">

                                        <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>assets/assets/images/upload.png);">
                                            <img id="image" src="">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_spp'); ?></p>
                                            <input type="file" onchange="eventFeaturePhoto()" name="profileimage" id="profileimage">
                                            <input type="hidden" name="x" id="x">
                                            <input type="hidden" name="y" id="y">
                                            <input type="hidden" name="width" id="width">
                                            <input type="hidden" name="height" id="height">
                                        </div>
                                    </div>


                                    <div class="col-md-6 destroy_cropper_div">
                                    	<div class="form-group label-floating">
                                    		<p class="image_select_text destroy_cropper"><i class="material-icons">crop</i> <?php echo $this->lang->line('dash_gpanel_clear_crop'); ?></p>
                                    	</div>
                                    </div>

                                    <div class="col-md-6 ini_cropper_div" style="display:none">
                                    	<div class="form-group label-floating">
                                    		<p class="image_select_text ini_cropper"><i class="material-icons">crop</i> <?php echo $this->lang->line('dash_gpanel_ini_crop'); ?></p>
                                    	</div>
                                    </div>
                                </div>

                                <input type="hidden" id="eventid" name="eventid" class="form-control" value="<?php echo $row->eventid; ?>" required>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title'); ?> (*)</label>
                                            <input type="text" id="eventtitle" name="eventtitle" class="form-control" value="<?php echo $row->eventtitle; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                            <input type="text" id="eventdate" name="eventdate" class="datepicker form-control" value="<?php echo $row->eventdate; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_time'); ?> (*)</label>
                                            <input type="text" id="eventtime" name="eventtime" class="form-control" value="<?php echo $row->eventtime; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_location'); ?> (*)</label>
                                            <input type="text" id="eventlocation" name="eventlocation" class="form-control" value="<?php echo $row->eventlocation; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description'); ?></label>
                                            <textarea rows="5" type="text" id="eventdescription" name="eventdescription" class="form-control"><?php echo $row->eventdescription; ?></textarea>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <button id="updateEventSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_updateevent_panel_title'); ?></button>
                                <div class="clearfix"></div>
                            </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
