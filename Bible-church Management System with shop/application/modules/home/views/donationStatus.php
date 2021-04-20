
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home">Donation Status</a></p>
            <h2>Donation</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <?php if($this->session->flashdata('success')){ ?>
                <h2 class="donation_success">Thank You For Your Donation</h2>
            <?php }else{ ?>
                <h2 class="donation_fail">Opps! Something Wrong, Please Try Again.</h2>
            <?php } ?>
            
        </div>
    </div>
</div>