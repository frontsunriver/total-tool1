
<?php if($page !=false){ ?>
    <?php foreach ($page as $row) : ?>

        <div class="wrapper_section">
            <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
                <div class="container">
                    <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/page/<?php echo $row->pageslug; ?>"><?php echo $row->pagetitle; ?></a></p>
                    <h2><?php echo $row->pagetitle; ?></h2>
                    <div class="separator-container">
                        <div class="separator line-separator">♦</div>
                    </div>
                    <div class="col-lg-offset-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-view single">
                            <div class="separator-container">
                                <div class="extra_space_sm"></div>
                            </div>
                            <div class="content">
                                <?php echo $row->pagecontent; ?>
                            </div>
                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
                            <div class="socialShare"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php }else{ ?>

    <div class="wrapper_section">
        <!-- <div class="container"> -->
        <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
            <div class="container">
                <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home">Page Not Found</a></p>
                <h2>Page</h2>
                <div class="separator-container">
                    <div class="separator line-separator">♦</div>
                </div>
                <h2 class="donation_fail">Page Not Found!</h2>
            </div>
        </div>
    </div>

<?php } ?>
