
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allevent">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/event">Event</a></p>
            <h2>Event</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <?php
            $num = 1;
            $breaker = 3; //Loop Break After 3 Cycle	
            foreach ($event as $event){                 
            if ($num == 1){
                echo '<div class="row">'; //First col, so open the row.
            }
            
            ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="seminar">
                    <img src="<?php echo base_url();?>assets/assets/images/event/feature/<?php echo $event->eventimage;?>" alt="Event Banner"></img>
                    <h5><span><i class="fa fa-calendar"></i> Time - <?php echo $event->eventtime;?>, <?php echo $event->eventdate;?></span> <span><i class="fa fa-map-marker"></i> Location - <?php echo $event->eventlocation;?></span></h5>
                    <h4><a   href="<?php echo base_url();?>home/event/view/<?php echo $event->eventid;?>"><?php echo $event->eventtitle;?></a></h4>
                </div>
            </div>
            <?php 
            $num++;
            if ($num > $breaker) {
                echo '</div>';
                $num = 1;
            }
            } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div> 
        </div>
    </div>
</div> 




