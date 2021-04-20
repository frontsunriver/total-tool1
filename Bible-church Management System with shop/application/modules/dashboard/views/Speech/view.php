<?php foreach ($individual as $row): ?>
    <div class="content user-profile">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card card-profile">
                        <div class="card-avatar">						
                            <img class="img" src="<?php echo base_url(); ?>assets/assets/images/<?php if($row->profileimage){ echo "speech/profile/" . $row->profileimage; }else{ echo "avatar.png"; } ?>" alt="<?php echo $row->fname; ?>">

                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="category text-gray"><?php echo $row->position; ?></h6>
                                </div>

                                <div class="col-md-12">
                                    <h4 class="card-title"><?php echo $row->fname . " " . $row->lname; ?></h4>
                                </div>

                                <div class="col-md-12">
                                    <p class="description">
                                        <?php echo strip_tags($row->speech); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="action-btn">
                                    <a href="<?php echo base_url(); ?>dashboard/speech/edit/<?php echo $row->speechid; ?>" class="btn btn-warning btn-sm"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                    <a href="<?php echo base_url(); ?>dashboard/speech/delete/<?php echo $row->speechid; ?>" class="btn btn-danger btn-sm delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>