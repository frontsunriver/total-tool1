
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allperson">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/clan">Clan</a></p>
            <h2>Clan</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <?php foreach ($clan as $clan){ ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="pastors">
                    <img src="<?php echo base_url();?>assets/assets/images/clan/profile/<?php echo $clan->profileimage;?>" alt="Pastor - <?php echo $clan->fname. " " . $clan->lname;?>"></img>
                    <h4><a   href="<?php echo base_url();?>home/clan/view/<?php echo $clan->clanid;?>"><?php echo $clan->fname. " " . $clan->lname;?></a></h4>
                    <h5><?php echo $clan->position;?></h5>
                </div>
            </div>
            <?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div> 
        </div>
    </div>
</div> 




