<div class="content">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">flare</i> <?php echo $this->lang->line('dash_updateseminar_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="updateSeminarForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/seminar/update" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-offset-0 col-md-12">
                                    <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>assets/assets/images/upload.png);">
                                        <img id="image" src="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_ssb'); ?></p>
                                        <input type="file" onchange="seminarbanner()" name="profileimage" id="profileimage">
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

                            <?php foreach ($individual as $row): ?>
                                <input type="hidden" id="seminarid" name="seminarid" value="<?php echo $row->seminarid; ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title'); ?> (*)</label>
                                            <input type="text" id="title" name="title" class="form-control" value="<?php echo $row->seminartitle; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_slogan'); ?> (*)</label>
                                            <input type="text" id="slogan" name="slogan" class="form-control" value="<?php echo $row->seminarslogan; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description'); ?> (*)</label>
                                            <textarea type="text" id="description" name="description" class="form-control"  required><?php echo $row->seminardescription; ?></textarea>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_start'); ?> (*)</label>
                                            <input type="text" id="sstart" name="sstart" class="form-control datepicker" value="<?php echo $row->seminarstart; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_end'); ?> (*)</label>
                                            <input type="text" id="send" name="send" class="form-control datepicker" value="<?php echo $row->seminarend; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_location'); ?></label>
                                            <input type="text" id="location" name="location" value="<?php echo $row->seminarlocation; ?>" class="form-control">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                            <button id="updateSeminarSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_updateseminar_panel_title'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
