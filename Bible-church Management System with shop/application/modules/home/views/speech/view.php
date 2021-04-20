
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/speech">Speech</a></p>
            <h2>Speech</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($speech as $speech) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="person-view">
                        <div class="row">
                            <img src="<?php echo base_url(); ?>assets/assets/images/speech/profile/<?php echo $speech->profileimage; ?>" alt="Speech - <?php echo $speech->fname . " " . $speech->lname; ?>"></img>
                            <h5><?php echo $speech->position; ?></h5>
                            <h4><a   href="<?php echo base_url(); ?>home/speech/view/<?php echo $speech->speechid; ?>"><?php echo $speech->fname . " " . $speech->lname; ?></a></h4>
                            <p><?php echo $speech->speech; ?></p>
                        </div>
                        
                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="social_media">
                                    <a class="socialbtn facebook" target="_blank" href="<?php echo $speech->facebook; ?>"><i class="fa fa-facebook"></i></a>
                                    <a class="socialbtn twitter" target="_blank" href="<?php echo $speech->twitter; ?>"><i class="fa fa-twitter"></i></a>
                                    <a class="socialbtn linkedin" target="_blank" href="<?php echo $speech->linkedin; ?>"><i class="fa fa-linkedin"></i></a>
                                    <a class="socialbtn googleplus" target="_blank" href="<?php echo $speech->googleplus; ?>"><i class="fa fa-google"></i></a>
                                    <a class="socialbtn youtube" target="_blank" href="<?php echo $speech->youtube; ?>"><i class="fa fa-youtube"></i></a>
                                    <a class="socialbtn pinterest" target="_blank" href="<?php echo $speech->pinterest; ?>"><i class="fa fa-pinterest"></i></a>
                                    <a class="socialbtn instagram" target="_blank" href="<?php echo $speech->instagram; ?>"><i class="fa fa-instagram"></i></a>
                                    <a class="socialbtn whatsapp" target="_blank" href="tel:<?php echo $speech->whatsapp; ?>"><i class="fa fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>
                    </div>

                    <div class="separator-container">
                        <div class="extra_space_sm"></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
                        <div class="socialShare"></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div> 