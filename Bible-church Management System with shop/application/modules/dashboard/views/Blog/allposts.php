<div class="content gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">
                            <i class="material-icons">speaker_notes</i>
                            <?php echo $this->lang->line('dash_allposts_panel_title'); ?>
                            ( <?php echo count($blog); ?> )</h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newblog'); ?> <?php echo getCreateDate('postID', 'blog'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtSermon table table-hover">
                            <thead class="text-default">
                                <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_title'); ?></th>
                                <th style="width: 30%"><?php echo $this->lang->line('dash_gpanel_description'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_time'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_author'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($blog as $row) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row->title; ?></td>
                                        <td><?php echo character_limiter(strip_tags($row->content), 100); ?></td>
                                        <td><?php echo $row->cdate; ?></td>
                                        <td><?php if (getUserByID($row->author)) {
                                                echo getUserByID($row->author)->username;
                                            } ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>home/blog/view/<?php echo $row->postID; ?>" target="_blank" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/blog/edit/<?php echo $row->postID; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/blog/delete/<?php echo $row->postID; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
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