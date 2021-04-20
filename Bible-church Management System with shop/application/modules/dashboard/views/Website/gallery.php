<div class="content">
    <div class="container">
        <div class="row">
            <div class="#">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_addgallery_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="website_gallery_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/website/uploadgallery" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-offset-1 col-md-4">
                                    <div class="form-group label-floating">
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_addimage'); ?> (*)</p>
                                        <input type="file" id="gallery" name="userfile[]"  class="form-control" multiple="multiple">
                                    </div>
                                </div>
                            </div>
                            <button id="website_gallery_submit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_add_now'); ?></button>
                        </form>
                    </div>
                </div>

                <div class="card gusers">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_allgallery_panel_title'); ?> ( <?php
                            $this->db->from('gallery');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newgallery'); ?> <?php echo getCreateDate('galleryid','gallery'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover sorted_gallery_table">
                            <thead class="text-default">
                            <th style="width: 1%"><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th style="width: 3%"><?php echo $this->lang->line('dash_gpanel_photo'); ?></th>
                            <th style="width: 5%"><?php echo $this->lang->line('dash_gpanel_title'); ?></th>
                            <th style="width: 4%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($gallery as $row) {
                                    $i++;
                                    ?>
                                    <tr data-id="<?php echo $row->galleryid; ?>" style="color: rgba(33, 33, 33, 0.70); font-weight: bold" class="parent-gallery">
                                        <td><?php echo $i; ?></td>
                                        <td title="Click & Hold To Sort/Rearrange Section" ><img style="width: 80px;" src="<?php echo base_url(); ?>assets/assets/images/website/gallery/small/<?php echo $row->filename; ?>"></td>                                        
                                        <td><?php echo $row->filename; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/website/gallerydelete/<?php echo $row->galleryid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
