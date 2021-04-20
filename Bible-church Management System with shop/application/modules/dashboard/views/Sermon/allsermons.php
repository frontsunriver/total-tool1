<div class="content gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">notifications_active</i> <?php echo $this->lang->line('dash_allsermons_panel_title'); ?> (<?php
                            $this->db->from('sermon');
                            echo $this->db->count_all_results();
                            ?>)</h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newsermon'); ?> <?php echo getCreateDate('sermonid','sermon'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtSermon table table-hover">
                            <thead class="text-default">
                            <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_image'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_title'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_date'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_time'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_location'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($sermon as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php if ($row->sermonbanner) { ?>
                                                <img class="committee img" src="<?php echo base_url(); ?>assets/assets/images/sermon/feature/<?php echo $row->sermonbanner; ?>">
                                            <?php } else { ?>
                                                <img class="committee img" src="<?php echo base_url(); ?>assets/assets/images/thumb.jpg">
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $row->sermontitle; ?></td>
                                        <td><?php echo $row->sermondate; ?></td>
                                        <td><?php echo $row->sermontime; ?></td>
                                        <td><?php echo $row->sermonlocation; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>home/sermon/view/<?php echo $row->sermonid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/sermon/edit/<?php echo $row->sermonid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/sermon/delete/<?php echo $row->sermonid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
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
