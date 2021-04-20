<div class="content gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">notifications_active</i> <?php echo $this->lang->line('dash_allevents_panel_title'); ?> (<?php
                            $this->db->from('event');
                            echo $this->db->count_all_results();
                            ?>)</h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newevent'); ?> <?php echo getCreateDate('eventid','event'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtEvent table table-hover">
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
                                foreach ($event as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php if ($row->eventimage) { ?>
                                                <img class="committee img" src="<?php echo base_url(); ?>assets/assets/images/event/feature/<?php echo $row->eventimage; ?>">
                                            <?php } else { ?>
                                                <img class="committee img" src="<?php echo base_url(); ?>assets/assets/images/thumb.jpg">
                                            <?php } ?>										
                                        </td>
                                        <td><?php echo $row->eventtitle; ?></td>
                                        <td><?php echo $row->eventdate; ?></td>
                                        <td><?php echo $row->eventtime; ?></td>
                                        <td><?php echo $row->eventlocation; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/event/view/<?php echo $row->eventid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/event/edit/<?php echo $row->eventid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/event/delete/<?php echo $row->eventid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
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