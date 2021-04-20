
<div class="content allmembers gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><?php echo $this->lang->line('dash_allmember_panel_title'); ?> ( <?php
                            $this->db->from('member');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newmember'); ?> <?php echo getCreateDate('memberid','member'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtMembers table table-hover">
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
                                foreach ($member as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <img class="committee img" src="<?php echo base_url(); ?>assets/assets/images/<?php if($row->profileimage){ echo "member/profile/" . $row->profileimage; }else{ echo "avatar.png"; } ?>">
                                        </td>
                                        <td><?php echo $row->fname . " " . $row->lname; ?></td>
                                        <td><?php echo $row->position; ?></td>
                                        <td><?php echo $row->phone; ?></td>
                                        <td><?php echo $row->country; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/member/view/<?php echo $row->memberid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/member/edit/<?php echo $row->memberid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/member/delete/<?php echo $row->memberid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
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