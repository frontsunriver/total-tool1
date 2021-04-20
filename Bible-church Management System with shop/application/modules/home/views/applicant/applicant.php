
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allperson">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/applicant">Applicant</a></p>
            <h2>All Applicants</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>            
            <?php foreach ($applicant as $applicant){ ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="pastors">
                    <img src="<?php echo base_url();?>assets/assets/images/seminar/profile/<?php echo $applicant->profileimage;?>" alt="Applicant - <?php echo $applicant->fname. " " . $applicant->lname;?>"></img>
                    <h5><?php echo $applicant->church;?></h5>
                    <h4><a   href="<?php echo base_url();?>home/applicant/view/<?php echo $applicant->seminarregid;?>"><?php echo $applicant->fname. " " . $applicant->lname;?></a></h4>
                  </div>
            </div>
            <?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div>  
        </div>        
    </div>
</div> 