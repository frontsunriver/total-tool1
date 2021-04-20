			
<?php foreach ($individual as $row)
     ?>	

<div class="content">
    <div class="container">
        <div class="xxxrow">	                    
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">people</i> <?php echo $this->lang->line('dash_updatefamily_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">

                        <form id="updateFamilyForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/family/update" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" id="familyid" name="familyid" value="<?php echo $row->familyid; ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_familyname'); ?> (*)</label>
                                        <input type="text" name="familyname" class="form-control" value="<?php echo $row->familyname; ?>" required>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_familyleader'); ?></label>
                                        <input type="text" id="lname" name="familyleader" class="form-control"  value="<?php echo $row->familyleader; ?>" >
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <div class="row">	                                        
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_familyquantity'); ?></label>
                                        <input type="number" min="1" id="phone" name="memberquantity" class="form-control" value="<?php echo $row->memberquantity; ?>">
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_familycontact'); ?></label>
                                        <input type="text" id="email" name="familycontact" class="form-control" value="<?php echo $row->familycontact; ?>">
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
                            
                            

                            <button id="updateFamilySubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_updatefamily_panel_title'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>