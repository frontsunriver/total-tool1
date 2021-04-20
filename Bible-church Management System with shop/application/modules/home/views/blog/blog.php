
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allevent">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/blog">Blog</a></p>
            <h2>Blog</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <?php             
            $num = 1;
            $breaker = 3; //Loop Break After 3 Cycle	        
            foreach ($blog as $blog){
            if ($num == 1){
                echo '<div class="row">'; //First col, so open the row.
            } ?>
            
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="seminar">
                    
                    <?php if($blog->image){ ?>
                        <img src="<?php echo base_url(); ?>assets/assets/images/blog/<?php echo $blog->image; ?>" alt="<?php echo $blog->title;?>"></img>
                    <?php }else{ ?>
                        <img src="<?php echo base_url(); ?>assets/assets/images/no-preview.png" alt="<?php echo $blog->title;?>"></img>
                    <?php } ?>
                            
                    <h4><a   href="<?php echo base_url(); ?>home/blog/view/<?php echo $blog->postID; ?>"><?php echo $blog->title; ?></a></h4>
                    <h5><span><i class="fa fa-calendar"></i> Published - <?php echo $blog->cdate; ?></span> <?php if(getUserByID($blog->author)){?> <span><i class="fa fa-map-person"></i> Author - <?php echo getUserByID($blog->author)->username; ?> </span> <?php } ?> </h5>
                    <h5><?php echo character_limiter(strip_tags($blog->content), 150); ?> </h5>
                    
                </div>
            </div>
            <?php             
                $num++;
                if ($num > $breaker) {
                    echo '</div>';
                    $num = 1;
                }
            } 
            
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div> 
        </div>
    </div>
</div> 




