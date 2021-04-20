
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/prayer">Prayer</a></p>
            <h2>Prayer</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($prayer as $prayer) { ?>
                <div class="col-lg-offset-1 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <div class="seminar single">
                        <h4 class="title"><a href="<?php echo base_url(); ?>home/prayer/view/<?php echo $prayer->prayerid; ?>"><span class="title-icon"> <i class="fa fa-microphone"></i> </span> <?php echo $prayer->prayertitle; ?></a></h4>
                        <?php echo $prayer->prayerdescription; ?>
                    </div>
                </div>
            <?php } ?>

            <div class="separator-container">
                <div class="extra_space_sm"></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
                <div class="socialShare"></div>
            </div>

        </div>
    </div>
</div>