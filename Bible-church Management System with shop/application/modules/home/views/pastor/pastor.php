
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allperson">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/pastor">Pastor/Ministry</a></p>
            <h2>Pastor/Ministry</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>            
            <?php foreach ($pastor as $pastor){ ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="pastors">
                    <img src="<?php echo base_url();?>assets/assets/images/pastor/profile/<?php echo $pastor->profileimage;?>" alt="Pastor - <?php echo $pastor->fname. " " . $pastor->lname;?>"></img>
                    <h4><a   href="<?php echo base_url();?>home/pastor/view/<?php echo $pastor->pastorid;?>"><?php echo $pastor->fname. " " . $pastor->lname;?></a></h4>
                    <h5><?php echo $pastor->position;?></h5>
                </div>
            </div>
            <?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div>  
        </div>        
    </div>
</div> 