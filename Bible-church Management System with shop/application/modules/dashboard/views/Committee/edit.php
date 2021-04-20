

<div class="content">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">people</i> <?php echo $this->lang->line('dash_updatecommittee_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <?php foreach ($individual as $row): ?>
                            <form id="updateCommitteeForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/committee/update" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-6">

                                        <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>assets/assets/images/upload.png);">
                                            <img id="image" src="">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_spp'); ?></p>
                                            <input type="file" onchange="previewFile()" name="profileimage" id="profileimage">
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

                                <input type="hidden" id="committeeid" name="committeeid" value="<?php echo $row->committeeid; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_fname'); ?> (*)</label>
                                            <input type="text" id="fname" name="fname" class="form-control" value="<?php echo $row->fname; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_lname'); ?></label>
                                            <input type="text" id="lname" name="lname" class="form-control" value="<?php echo $row->lname; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_phone'); ?> (*)</label>
                                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $row->phone; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_email'); ?></label>
                                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $row->email; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_position'); ?> (*)</label>
                                            <input type="text" id="position" name="position" class="form-control" value="<?php echo $row->position; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_bpdate'); ?></label>
                                            <input type="text" id="bpdate" name="bpdate" class="datepicker form-control" value="<?php echo $row->bpdate; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_marriagedate'); ?></label>
                                            <input type="text" name="marriagedate" class="datepicker form-control" value="<?php echo $row->marriagedate; ?>">
                                            <span class="material-input"></span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_socialstatus'); ?></label>
                                            <input type="text" name="socialstatus" class="form-control" value="<?php echo $row->socialstatus; ?>">
                                            <span class="material-input"></span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_job'); ?></label>
                                            <input type="text" name="job" class="form-control" value="<?php echo $row->job; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_family'); ?></label>
                                        <select id="family" name="family" class="select form-control">
                                            <option value="">Select Family</option>
                                            <option selected value="<?php echo $row->family; ?>"><?php echo $row->family; ?> (Current)</option>
                                            <?php foreach ($family as $family){ ?>
                                                <option value="<?php echo $family->familyname; ?>"><?php echo $family->familyname; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_department'); ?></label>
                                        <select id="department" name="department" class="select form-control">
                                            <option value="">Select Department</option>
                                            <option selected value="<?php echo $row->department; ?>"><?php echo $row->department; ?> (Current)</option>
                                            <?php foreach ($department as $department){ ?>
                                                <option value="<?php echo $department->departmentname; ?>"><?php echo $department->departmentname; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_blood'); ?></label>
                                            <input type="text" id="blood" name="blood" class="form-control" value="<?php echo $row->blood; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_dob'); ?></label>
                                            <input type="text" id="dob" name="dob" class="datepicker form-control" value="<?php echo $row->dob; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_nationality'); ?></label>
                                            <input type="text" id="nationality" name="nationality" class="form-control" value="<?php echo $row->nationality; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_speech'); ?></label>
                                            <textarea type="text" id="speech" name="speech" class="form-control"><?php echo $row->speech; ?></textarea>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_address'); ?></label>
                                            <textarea type="text" id="address" name="address" class="form-control"><?php echo $row->address; ?></textarea>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_city'); ?></label>
                                            <input type="text" id="city" name="city" class="form-control" value="<?php echo $row->city; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_country'); ?></label>
                                            <input type="text" id="country" name="country" class="form-control" value="<?php echo $row->country; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_zone'); ?></label>
                                            <input type="text" id="postal" name="postal" class="form-control" value="<?php echo $row->postal; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_facebook'); ?></label>
                                            <input type="text" id="fname" name="facebook" class="form-control" value="<?php echo $row->facebook; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_twitter'); ?></label>
                                            <input type="text" id="fname" name="twitter" class="form-control" value="<?php echo $row->twitter; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_googleplus'); ?></label>
                                            <input type="text" id="lname" name="googleplus" class="form-control" value="<?php echo $row->googleplus; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_linkedin'); ?></label>
                                            <input type="text" id="position" name="linkedin" class="form-control" value="<?php echo $row->linkedin; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_youtube'); ?></label>
                                            <input type="text" id="fname" name="youtube" class="form-control" value="<?php echo $row->youtube; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pinterest'); ?></label>
                                            <input type="text" id="fname" name="pinterest" class="form-control" value="<?php echo $row->pinterest; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_instagram'); ?></label>
                                            <input type="text" id="lname" name="instagram" class="form-control" value="<?php echo $row->instagram; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_whatsapp'); ?></label>
                                            <input type="text" id="position" name="whatsapp" class="form-control" value="<?php echo $row->whatsapp; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <button id="updateCommitteeSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_updatecommittee_panel_title'); ?></button>
                                <div class="clearfix"></div>
                            </form>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
