<div class="content gusers">
    <div class="container">        
        
        <div class="xxxrow">	                    
            <div class="xxxcol-md-offset-0 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">assignment_turned_in</i> <?php echo $this->lang->line('dash_gpanel_attendance'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="browse_attendance_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/attendance/browse" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                        <input type="text" id="fdate" name="attendancedate" class="datepicker form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_grouptype'); ?> (*)</label>				
                                        <select id="grouptype" name="grouptype" class="select form-control" required>
                                            <option value="">Select Group Type</option>
                                            <option value="committee">Committee</option>
                                            <option value="pastor">Pastor</option>
                                            <option value="member">Member</option>
                                            <option value="chorus">Chorus</option>
                                            <option value="clan">Clan</option>
                                            <option value="students">Sunday School Students</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_attendancetype'); ?> (*)</label>				
                                        <select id="attendancetype" name="attendancetype" class="select form-control" required>
                                            <option value="">Select Attendance Type</option>
                                            <?php foreach ($attendancetypes as $row){ ?>
                                                <option value="<?php echo $row->attendancetype; ?>"><?php echo $row->attendancetype; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right"><i class="material-icons">assignment_turned_in</i> <?php echo $this->lang->line('dash_gpanel_browse_now'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>