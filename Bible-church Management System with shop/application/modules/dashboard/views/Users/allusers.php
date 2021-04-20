
<div class="content allusers gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">
                            <?php echo $this->lang->line('dash_alluser_panel_title'); ?>
                            ( <?php
                            $this->db->from('users');
                            echo $this->db->count_all_results();
                            ?> ) 
                        </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newuser'); ?> <?php echo getCreateDate('userid','users'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtUser table table-hover">
                            <thead class="text-default">
                            <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_photo'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_name'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_position'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_phone'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_country'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($users as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <img class="committee img" src="<?php echo base_url(); ?>assets/assets/images/<?php if($row->profileimage){ echo "users/profile/" . $row->profileimage; }else{ echo "avatar.png"; } ?>">
                                        </td>
                                        <td><?php echo $row->fname . " " . $row->lname; ?></td>
                                        <td><?php echo $row->position; ?></td>
                                        <td><?php echo $row->phone; ?></td>
                                        <td><?php echo $row->country; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/user/view/<?php echo $row->userid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/user/edit/<?php echo $row->userid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/user/delete/<?php echo $row->userid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
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