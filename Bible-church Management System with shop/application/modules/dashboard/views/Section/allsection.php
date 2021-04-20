<div class="content allpastors">
    <div class="container-fluid">
        <?php
        $num = 1;
        $breaker = 3; //How many cols inside a row?
        foreach ($pastor as $row) {
            if ($num == 1)
                echo '<div class="row">'; //First col, so open the row.
            ?>

            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-avatar">							
                        <img class="committee img" src="<?php echo base_url(); ?>assets/assets/images/pastor/profile/<?php echo $row->profileimage; ?>">
                    </div>

                    <div class="content">
                        <h6 class="category text-gray"><?php echo $row->position; ?></h6>
                        <h4 class="card-title"><?php echo $row->fname . " " . $row->lname; ?></h4>
                        <p class="card-content speech"><?php echo word_limiter(strip_tags($row->speech), 20); ?></p>

                        <div class="col-md-12 action-btn">
                            <a href="<?php echo base_url(); ?>dashboard/pastor/view/<?php echo $row->pastorid; ?>" class="btn btn-primary btn-round"><i class="material-icons">call_made</i> View</a>
                            <a href="<?php echo base_url(); ?>dashboard/pastor/edit/<?php echo $row->pastorid; ?>" class="btn btn-warning btn-round"><i class="material-icons">add</i> Edit</a>
                            <a href="<?php echo base_url(); ?>dashboard/pastor/delete/<?php echo $row->pastorid; ?>" class="btn btn-danger btn-round delete"><i class="material-icons">clear</i> Delete</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $num++;
            if ($num > $breaker) {
                echo '</div>';
                $num = 1;
            }
        }
        ?>

        <?php echo $pagination; ?>
    </div>
</div>