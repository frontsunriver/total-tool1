<div class="content website">
    <div class="container">
        <div class="row">	                    
            <div class="#">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_updatepage_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content"> 
                        <form id="webPageUpdateForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/website/updatepage" method="post" enctype="multipart/form-data">
                            <?php foreach ($individual as $row):?>
                            <input type="hidden" name="pageid" value="<?php echo $row->pageid; ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pagetitle'); ?> (*)</label>
                                        <input id="title" name="title" type="text" class="form-control" value="<?php echo $row->pagetitle; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pageslug'); ?> (*)</label>
                                        <input id="slug" name="slug" type="text" class="form-control" value="<?php echo $row->pageslug; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pagecontent'); ?> (*)</label>
                                        <textarea id="pagecontent" name="content" type="text" class="form-control"><?php echo $row->pagecontent; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <button id="webPageUpdateSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_updatepage_panel_title'); ?></button>
                            <div class="clearfix"></div>
                            <?php endforeach; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>