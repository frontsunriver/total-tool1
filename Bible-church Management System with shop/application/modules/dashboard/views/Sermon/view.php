<?php foreach ($individual as $row): ?>
    <div class="content view_sermon">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">				
                    <div class="card card-product">
                        <div class="card-image">						
                            <img class="img" style="height:350px;" src="<?php echo base_url(); ?>assets/assets/images/sermon/feature/<?php
                            if ($row->sermonbanner) {
                                echo $row->sermonbanner;
                            } else {
                                echo "banner.jpg";
                            }
                            ?> ">						
                        </div>
                        <div class="card-content">						
                            <h4 class="card-title">
                                <a href="#"><?php echo $row->sermontitle; ?></a>
                            </h4>
                            <div class="card-description">
                                <?php echo $row->sermondescription; ?>
                            </div>
                        </div>
                        <div class="card-content sermon-element">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">date_range</i> Date - <?php echo $row->sermondate; ?></p>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">access_time</i> Time - <?php echo $row->sermontime; ?></p>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">place</i> Location - <?php echo $row->sermonlocation; ?></p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">person</i> Author - <?php echo $row->sermonauthor; ?></p>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">videocam</i> Youtube - <a href="<?php echo $row->sermonyoutube; ?>" target="_blank">Youtube Video</a> </p>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">music_video</i> Sound Cloud - <a href="<?php echo $row->sermonsoundcloud; ?>" target="_blank">Sound Cloud Music</a> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>