<div class="content website">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_updatemenu_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="menuUpdateForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/menu/update" method="post" enctype="multipart/form-data">
                            <?php foreach ($individual as $row): ?>
                                <input type="hidden" name="menuid" value="<?php echo $row->menuid; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menuname'); ?> (*)</label>
                                            <input id="menuname" name="menuname" type="text" class="form-control" value="<?php echo $row->menuname; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menuparent'); ?></label>
                                            <select class="select form-control" id="menuparent" name="menuparent">
                                                <option value=""><?php echo $this->lang->line('dash_gpanel_smenuparent'); ?></option>
                                                <?php if($selectedparent[0]->menuparentid){ ?>
                                                  <option selected="" value="<?php echo $selectedparent[0]->menuparentid; ?>"><?php echo $selectedparent[1]->menuname; ?> (Current Parent Menu)</option>
                                                <?php } ?>
                                                <?php foreach ($menus as $mrow){ ?>
                                                    <option value="<?php echo $mrow->menuid; ?>"><?php echo $mrow->menuname; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menupage'); ?></label>
                                            <select class="select form-control" id="menupage" name="menupage">
                                                <option value=""><?php echo $this->lang->line('dash_gpanel_smenupage'); ?></option>
                                                <?php if($selectedpage->pageslug){ ?>
                                                    <option selected="" value="<?php echo $selectedpage->pageslug; ?>"><?php echo $selectedpage->pagetitle; ?> (Current Page)</option>
                                                <?php }?>

                                                <?php foreach ($pages as $prow){ ?>
                                                    <option value="<?php echo $prow->pageslug; ?>"><?php echo $prow->pagetitle; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menulink'); ?></label>
                                            <input id="menulink" name="menulink" type="text" class="form-control" value="<?php echo $row->menulink; ?>">
                                        </div>
                                    </div>
                                    <button id="menuUpdateSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_updatemenu_panel_title'); ?></button>
                                    <div class="clearfix"></div>
                                </div>
                            <?php endforeach; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
