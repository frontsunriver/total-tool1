<div class="content allspeechs">
    <div class="container">
        <?php
        $num = 1;
        $breaker = 3; //How many cols inside a row?
        foreach ($speech as $row) {
            if ($num == 1){
                echo '<div class="row">'; //First col, so open the row.
            }
            ?>

            <div class="col-md-4">
                <div class="allspeechs card card-profile">
                    <div class="card-avatar">
                        <img class="committee img" src="<?php echo base_url(); ?>assets/assets/images/<?php if($row->profileimage){ echo "speech/profile/" . $row->profileimage; }else{ echo "avatar.png"; } ?>">
                    </div>

                    <div class="content">
                        <h6 class="category text-gray"><?php echo $row->position; ?></h6>
                        <h4 class="card-title"><?php echo $row->fname . " " . $row->lname; ?></h4>
                        <p class="card-content speech"><?php echo word_limiter(strip_tags($row->speech), 20); ?></p>

                        <div class="col-md-12 action-btn">
                            <a href="<?php echo base_url(); ?>home/speech/view/<?php echo $row->speechid; ?>" class="btn btn-primary btn-round"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                            <a href="<?php echo base_url(); ?>dashboard/speech/edit/<?php echo $row->speechid; ?>" class="btn btn-warning btn-round"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                            <a href="<?php echo base_url(); ?>dashboard/speech/delete/<?php echo $row->speechid; ?>" class="btn btn-danger btn-round delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $num++;
            if($num == 4) {
                echo '</div>';
                $num = 1;
            }
        }
        ?>


    </div>

    <div class="col-md-12">
        <?php echo $pagination; ?>
    </div>
