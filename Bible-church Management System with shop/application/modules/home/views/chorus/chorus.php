
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allperson">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/chorus">Chorus</a></p>
            <h2>All Chorus</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <?php foreach ($chorus as $chorus){ ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="pastors">
                    <img src="<?php echo base_url();?>assets/assets/images/chorus/profile/<?php echo $chorus->profileimage;?>" alt="Chorus - <?php echo $chorus->fname. " " . $chorus->lname;?>"></img>
                    <h5><?php echo $chorus->position;?></h5>
                    <h4><a   href="<?php echo base_url();?>home/chorus/view/<?php echo $chorus->chorusid;?>"><?php echo $chorus->fname. " " . $chorus->lname;?></a></h4>
                 </div>
            </div>
            <?php } ?>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div>  
        </div>
    </div>
</div> 




