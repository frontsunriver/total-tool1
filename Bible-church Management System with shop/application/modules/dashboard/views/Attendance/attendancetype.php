<div class="content gusers">
    <div class="container">        
        
        <div class="xxxrow">	                    
            <div class="xxxcol-md-offset-0 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">assignment_turned_in</i> <?php echo $this->lang->line('dash_gpanel_addattendancetype'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="attendanceTypeForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/attendance/browse" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_attendance'); ?> (*)</label>
                                        <input type="text" name="attendancetype" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <button id="attendanceTypeSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">assignment_turned_in</i> <?php echo $this->lang->line('dash_gpanel_add_now'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
                
                
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">assignment_turned_in</i> <?php echo $this->lang->line('dash_gpanel_allattendancetype'); ?> ( <?php
                            $this->db->from('attendancetype');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category">--</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtChorus table table-hover">
                            <thead class="text-default">
                            <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_name'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($attendancetypes as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>                                        
                                        <td><?php echo $row->attendancetype; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/attendance/delete/<?php echo $row->attendancetypeid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                
            </div>            
        </div>
    </div>
</div>