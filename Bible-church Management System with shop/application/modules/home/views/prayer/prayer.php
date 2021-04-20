
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allprayer">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/prayer">Prayer</a></p>
            <h2>Prayer</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <?php foreach ($prayer as $prayer){ ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="seminar">
                    <h4 class="title"><a href="<?php echo base_url();?>home/prayer/view/<?php echo $prayer->prayerid;?>"><span class="title-icon"> <i class="fa fa-microphone"></i> </span> <?php echo character_limiter($prayer->prayertitle, 15);?></a></h4>
                    <?php echo word_limiter($prayer->prayerdescription, 50);?>
                </div>
            </div>
            <?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div> 
        </div>
    </div>
</div> 