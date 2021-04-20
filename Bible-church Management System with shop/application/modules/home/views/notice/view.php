
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/notice">Notice</a></p>
            <h2>Notice</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($notice as $notice) { ?>
                <div class="col-lg-offset-2 col-lg-8 col-md-6 col-sm-12 col-xs-12">
                    <div class="prayer-view single">
                        <h4 class="title"><span class="title-icon">
                                <i class="fa fa-microphone"></i>
                            </span> <a   href="<?php echo base_url(); ?>home/notice/view/<?php echo $notice->noticeid; ?>"><?php echo $notice->noticetitle; ?></a></h4>
                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>
                        <h4><?php echo $notice->noticedescription; ?></h4>
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