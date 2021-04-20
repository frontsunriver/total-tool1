
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allgallery">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/gallery">Gallery</a></p>
            <h2>Gallery</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <div class="col-md-offset-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="singlePageGallery" style="display:none;">
                    <?php foreach ($gallery as $gallery) { ?>
                        <img alt="<?php echo $gallery->filename; ?>" src="<?php echo base_url(); ?>assets/assets/images/website/gallery/small/<?php echo $gallery->filename; ?>"
                        data-image="<?php echo base_url(); ?>assets/assets/images/website/gallery/large/<?php echo $gallery->filename; ?>"
                        data-description="<?php echo $gallery->filename; ?>">
                    <?php } ?>
                </div>
            </div>  
        </div>
    </div>
</div> 




