
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/blog">Blog</a></p>
            <h2>Blog</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($blog as $blog) { ?>
                <div class="col-md-8">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="seminar single">
                            <?php if($blog->image){ ?>
                                <img src="<?php echo base_url(); ?>assets/assets/images/blog/<?php echo $blog->image; ?>" alt="<?php echo $blog->title;?>"></img>
                            <?php }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/assets/images/no-preview.png" alt="<?php echo $blog->title;?>"></img>
                            <?php } ?>

                                <h5><span><i class="fa fa-calendar"></i> Published - <?php echo $blog->cdate; ?></span> <?php if(getUserByID($blog->author)){?> <span><i class="fa fa-map-person"></i> Author - <?php echo getUserByID($blog->author)->username; ?> </span> <?php } ?> </h5>
                            <h4><a   href="<?php echo base_url(); ?>home/blog/view/<?php echo $blog->postID; ?>"><?php echo $blog->title; ?></a></h4>
                        </div>

                        <div class="seminar-view">
                            <div class="row">
                                <h4><?php echo $blog->content; ?></h4>
                            </div>

                            <div class="separator-container">
                                <div class="extra_space_sm"></div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="fb-comments" data-href="<?php echo base_url();?>home/blog/view/11" data-numposts="5"></div>
                                </div>
                            </div>
                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                            <div class="socialShare"></div>
                        </div>

                    </div>
                </div>
            <?php } ?>

            <div class="col-md-4">
                <?php if( is_array($recents) ){ ?>
                <?php foreach ($recents as $recent){ ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="seminar">

                        <?php if($recent->image){ ?>
                            <img src="<?php echo base_url(); ?>assets/assets/images/blog/<?php echo $recent->image; ?>" alt="<?php echo $recent->title;?>"></img>
                        <?php }else{ ?>
                            <img src="<?php echo base_url(); ?>assets/assets/images/no-preview.png" alt="<?php echo $recent->title;?>"></img>
                        <?php } ?>
                        <h4><a   href="<?php echo base_url(); ?>home/blog/view/<?php echo $recent->postID; ?>"><?php echo $recent->title; ?></a></h4>
                        <h5><span><i class="fa fa-calendar"></i> Published - <?php echo $recent->cdate; ?></span> <?php if(getUserByID($recent->author)){?> <span><i class="fa fa-map-person"></i> Author - <?php echo getUserByID($recent->author)->username; ?> </span> <?php } ?> </h5>

                    </div>
                </div>
                <?php } ?>
                <?php } ?>

            </div>

        </div>
    </div>
</div>
