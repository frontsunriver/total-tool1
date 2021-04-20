<div class="content">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">line_style</i> <?php echo $this->lang->line('dash_addsection_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">

                        <form id="addSectionForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/section/addnewsection" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-offset-0 col-md-12">

                                    <!-- Wrap the image or canvas element with a block element (container) -->
                                    <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>assets/assets/images/upload.png);">
                                        <img id="image" src="">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_sbi'); ?></p>
                                        <input type="file" onchange="sectionbanner()" name="profileimage" id="profileimage">
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


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title'); ?> (*)</label>
                                        <input type="text" id="title" name="title" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_removebackground'); ?></label>
                                        <select class="select form-control" id="removebackground" name="removebackground">
                                            <option value=""><?php echo $this->lang->line('dash_gpanel_removebackground'); ?></option>
                                            <option value="Delete">Yes</option>
                                            <option value="Keep" >No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_section_onoff'); ?></label>
                                        <select class="select form-control" id="sectiononoff" name="sectiononoff">
                                            <option value=""><?php echo $this->lang->line('dash_section_onoff'); ?></option>
                                            <option value="Yes">Yes</option>
                                            <option value="No" >No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_shortcode'); ?></label>
                                        <input type="text" id="shortcode" name="shortcode" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_shortcode'); ?></label>
                                        <select class="select form-control" id="selectshortcode" name="selectshortcode" required>
                                            <option value=""><?php echo $this->lang->line('dash_gpanel_selectshortcode'); ?></option>
                                            <option value="group, committee, desc, committeeid, 4" >Committee</option>
                                            <option value="group, member, desc, memberid, 4" >Member</option>
                                            <option value="group, pastor, desc, pastorid, 4" >Pastor</option>
                                            <option value="group, chorus, desc, chorusid, 4" >Chorus</option>
                                            <option value="group, clan, desc, clanid, 4" >Clan</option>
                                            <option value="group, sundayschool, desc, sschoolid, 4" >Student</option>
                                            <option value="group, staff, desc, staffid, 4" >Staff</option>
                                            <option value="speech, speech, desc, speechid, 4" >Speech</option>
                                            <option value="event, seminar, desc, seminarid, 4" >Seminar</option>
                                            <option value="event, sermon, desc, sermonid, 4" >Sermon</option>
                                            <option value="event, blog, desc, postID, 8" >Blog</option>
                                            <option value="shop, product, desc, productID, 6" >Shop</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_content'); ?></label>
                                        <textarea type="text" id="content" name="content" class="form-control"></textarea>
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_link'); ?></label>
                                        <input type="text" id="link" name="link" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_btn_text'); ?></label>
                                        <input type="text" id="btntext" name="btntext" class="form-control">
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <button id="addSectionSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_addsection_panel_title'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="xxxcol-md-offset-1 xxxcol-md-10">
            <div class="card gusers">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title"><i class="material-icons">line_style</i> <?php echo $this->lang->line('dash_allsection_panel_title'); ?> ( <?php
                        $this->db->from('section');
                        echo $this->db->count_all_results();
                        ?> ) </h4>
                    <p class="category"><?php echo $this->lang->line('dash_gpanel_newsection'); ?>  <?php echo getCreateDate('sectionid','section'); ?></p>
                </div>
                <div class="card-content table-responsive">
                    <table class="table table-hover sorted_table">
                        <thead class="text-default">
                        <th style="width:5%" ><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                        <th style="width:20%"><?php echo $this->lang->line('dash_gpanel_title'); ?></th>
                        <th style="width:20%"><?php echo $this->lang->line('dash_section_onoff'); ?></th>
                        <th style="width:20%"><?php echo $this->lang->line('dash_gpanel_content'); ?></th>
                        <th style="width:20%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                        </thead>
                        <tbody>

                            <?php
                            if ($this->uri->segment(4)) {
                                $i = $this->uri->segment(4);
                            } else {
                                $i = "";
                            }
                            foreach ($section as $row) {
                                $i++;
                                ?>

                                <tr data-id="<?php echo $row->sectionid; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td title="Click & Hold To Sort/Rearrange Section"><?php echo $row->title; ?></td>
                                    <td><?php echo $row->sectiononoff; ?></td>
                                    <td><?php echo word_limiter(strip_tags($row->content), 10); ?></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>dashboard/section/edit/<?php echo $row->sectionid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                        <a href="<?php echo base_url(); ?>dashboard/section/delete/<?php echo $row->sectionid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php echo $pagination; ?>
        </div>
