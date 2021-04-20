<div class="content">
<div class="container">
<div class="xxxrow">
    <div class="xxxcol-md-offset-1 xxxcol-md-10">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title"><i class="material-icons">bookmark</i> <?php echo $this->lang->line('dash_updateprayer_panel_title');?></h4>
                <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar');?></p>
            </div>
            <div class="card-content">
                <form id="updatePrayerForm" class="form-horizontal" action="<?php echo base_url();?>dashboard/prayer/update" method="post" enctype="multipart/form-data">
                    <?php foreach($individual as $row):?>
                    <div class="row">
                        <input type="hidden" id="prayerid" name="prayerid" value="<?php echo $row->prayerid;?>">
                        <div class="col-md-12">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title');?> (*)</label>
                                <input type="text" id="title" name="title" class="form-control" value="<?php echo $row->prayertitle;?>" required>
                                <span class="material-input"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description');?></label>
                                <textarea rows="5" type="text" id="description" name="description" class="form-control"><?php echo $row->prayerdescription; ?></textarea>
                                <span class="material-input"></span>
                            </div>
                        </div>
                    </div>
                    <button id="updatePrayerSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">bookmark</i> <?php echo $this->lang->line('dash_updateprayer_panel_title');?></button>
                    <div class="clearfix"></div>
                    <?php endforeach;?>
                </form>
            </div>
        </div>
    </div>
</div>