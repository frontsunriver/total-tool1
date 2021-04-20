			
<?php foreach ($individual as $row)
     ?>	

<div class="content">
    <div class="container">
        <div class="xxxrow">	                    
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">people</i> <?php echo $this->lang->line('dash_updatedepartment_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">

                        <form id="updateDepartmentForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/department/update" method="post" enctype="multipart/form-data">
                            
                            <input type="hidden" id="departmentid" name="departmentid" value="<?php echo $row->departmentid; ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_dptname'); ?> (*)</label>
                                        <input type="text" name="departmentname" class="form-control" value="<?php echo $row->departmentname; ?>" required>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_dptleader'); ?></label>
                                        <input type="text" id="lname" name="departmentleader" class="form-control"  value="<?php echo $row->departmentleader; ?>" >
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <div class="row">	                                        
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_dptarea'); ?></label>
                                        <input type="text" id="phone" name="departmentarea" class="form-control" value="<?php echo $row->departmentarea; ?>">
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_dptcontact'); ?></label>
                                        <input type="text" id="email" name="departmentcontact" class="form-control" value="<?php echo $row->departmentcontact; ?>">
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description'); ?></label>
                                        <textarea type="text" id="description" name="description" class="form-control"><?php echo $row->description; ?></textarea>
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
                            
                            

                            <button id="updateDepartmentSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_updatedepartment_panel_title'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>