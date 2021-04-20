<div class="content gusers">
    <div class="container">
        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">bookmark</i> <?php echo $this->lang->line('dash_allprayer_panel_title'); ?> ( <?php echo count($prayer); ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newrequest'); ?> <?php echo getCreateDate('prayerid', 'prayer'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtPrayer table table-hover">
                            <thead class="text-default">
                                <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_title'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_description'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($prayer as $row) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row->prayertitle; ?></td>
                                        <td><?php
                                            $description = $row->prayerdescription;
                                            echo strip_tags(word_limiter($description, 7));
                                            ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>home/prayer/view/<?php echo $row->prayerid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/prayer/edit/<?php echo $row->prayerid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/prayer/delete/<?php echo $row->prayerid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
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