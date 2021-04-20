<div class="content website">
    <div class="container">
        <div class="row">	                    
            <div class="#">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_addpage_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">                       
                        <form id="webPageAddForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/website/addpage" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pagetitle'); ?> (*)</label>
                                        <input id="title" name="title" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pageslug'); ?> (*)</label>
                                        <input id="slug" name="slug" type="text" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pagecontent'); ?> (*)</label>
                                        <textarea id="pagecontent" name="content" type="text" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button id="webPageAddSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_addpage_panel_title'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>


                <div class="card gusers">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_allpages_panel_title'); ?> ( <?php
                            $this->db->from('page');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newmember'); ?> on 15th September, 2016</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead class="text-default">
                            <th  style="width:5%" ><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th style="width:10%"><?php echo $this->lang->line('dash_gpanel_pagetitle'); ?></th>
                            <th style="width:10%"><?php echo $this->lang->line('dash_gpanel_pageslug'); ?></th>
                            <th style="width:40%"><?php echo $this->lang->line('dash_gpanel_pagecontent'); ?></th>
                            <th style="width:20%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($pages as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>                                        
                                        <td><?php echo $row->pagetitle; ?></td>
                                        <td><?php echo $row->pageslug; ?></td>
                                        <td><?php echo word_limiter(strip_tags($row->pagecontent), 20); ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/website/pageedit/<?php echo $row->pageid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/website/pagedelete/<?php echo $row->pageid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php //echo $pagination; ?>
            </div>
        </div>