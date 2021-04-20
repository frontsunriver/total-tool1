
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allsermon">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/sermon">Sermon</a></p>
            <h2>Sermon</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($sermon as $row) { ?>
            
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sermon">
                        <div class="left">
                            <img src="<?php echo base_url();?>assets/assets/images/sermon/feature/<?php echo $row->sermonbanner;?>" alt="<?php echo $row->sermontitle;?>">
                        </div>
                        <div class="center">
                            <h4 class="title"><a href="<?php echo base_url();?>home/sermon/view/<?php echo $row->sermonid;?>"><?php echo $row->sermontitle; ?></a></h4>
                            <span class="elements">Time - <?php echo $row->sermontime; ?> | Date - <?php echo $row->sermondate; ?> | Pastor/Writer/Author - <?php echo $row->sermonauthor; ?></span>
                            <span class="elements"><?php echo character_limiter(strip_tags($row->sermondescription), 100); ?></span>
                        </div>    
                        <div class="right">
                            <button class="btn "><a href=<?php echo base_url();?>home/sermon/view/<?php echo $row->sermonid;?>><i class="fa fa-music fa-fw"></i> Audio</a></button> 
                            <button class="btn "><a href=<?php echo base_url();?>home/sermon/view/<?php echo $row->sermonid;?>><i class="fa fa-youtube fa-fw"></i> Video</a></button> 
                        </div>
                    </div>
                </div>					

            <?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php echo $pagination; ?>
            </div> 
        </div>
    </div>
</div> 




