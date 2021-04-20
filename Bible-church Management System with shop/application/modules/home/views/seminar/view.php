
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/seminar">Seminar</a></p>
            <h2>Seminar</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($seminar as $seminar) { ?>
                <div class="col-md-8">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="seminar single">
                            <img src="<?php echo base_url(); ?>assets/assets/images/seminar/banner/<?php echo $seminar->seminarbanner; ?>" alt="Seminar Banner"></img>
                            <h5><span><i class="fa fa-calendar"></i> Duration - <?php echo $seminar->seminarstart; ?> - <?php echo $seminar->seminarend; ?></span> <span><i class="fa fa-map-marker"></i> Location - <?php echo $seminar->seminarlocation; ?></span> <span><i class="fa fa-calendar-check-o"></i> Joined - <?php
                                    $seminarid = $seminar->seminarid;
                                    $this->db->like('selectedseminarid', $seminarid);
                                    $this->db->from('seminarregistration');
                                    echo $this->db->count_all_results();
                                    ?></span></h5>
                            <h4><a   href="<?php echo base_url(); ?>home/seminar/view/<?php echo $seminar->seminarid; ?>"><?php echo $seminar->seminartitle; ?></a></h4>
                        </div>

                        <div class="seminar-view">
                            <div class="row">
                                <h5><span class="quatation"><i class="fa fa-quote-left"></i> <?php echo $seminar->seminarslogan; ?> <i class="fa fa-quote-right"></i></span></h5>
                                <h4><?php echo $seminar->seminardescription; ?></h4>
                            </div>

                            <div class="separator-container">
                                <div class="extra_space_sm"></div>
                            </div>

                            <?php if(!empty($seminar->seminarlocation)){ ?>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <iframe
                                            width="100%"
                                            height="300"
                                            frameborder="0" style="border:0; pointer-events: none;"
                                            src="https://www.google.com/maps/embed/v1/place?key=<?php echo getBasic()->mapapi;?>
                                            &q=<?php echo $seminar->seminarlocation; ?>">
                                        </iframe>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>
                    </div>

                    <?php if($applicants !=false){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
                                <div class="allperson">
                                    <h2>Applicants</h2>
                                    <div class="separator-container">
                                        <div class="separator line-separator">♦</div>
                                    </div>
                                    <?php foreach ($applicants as $applicants) { ?>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <div class="pastors">
                                                <img src="<?php echo base_url(); ?>assets/assets/images/seminar/profile/<?php echo $applicants->profileimage; ?>" alt="Applicant - <?php echo $applicants->fname . " " . $applicants->lname; ?>"></img>
                                                <h5><?php echo $applicants->church; ?></h5>
                                                <h4><a   href="<?php echo base_url(); ?>home/applicant/view/<?php echo $applicants->seminarregid; ?>"><?php echo $applicants->fname . " " . $applicants->lname; ?></a></h4>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <?php echo $pagination; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="separator-container">
                                <div class="extra_space_sm"></div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="socialShare"></div>
                            </div>
                        </div>
                    <?php }?>


                </div>

                <div class="col-md-4">
                    <?php if( is_array($recents) ){ ?>
                    <?php foreach ($recents as $recent){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="seminar">
                                <img src="<?php echo base_url();?>assets/assets/images/seminar/banner/<?php echo $recent->seminarbanner;?>" alt="Seminar Banner"></img>
                                <h4><a   href="<?php echo base_url();?>home/seminar/view/<?php echo $recent->seminarid;?>"><?php echo $recent->seminartitle;?></a></h4>
                                <h5><span><i class="fa fa-calendar"></i> Duration - <?php echo $recent->seminarstart;?> - <?php echo $recent->seminarend;?></span> <span><i class="fa fa-map-marker"></i> Location - <?php echo $recent->seminarlocation;?></span> <span><i class="fa fa-calendar-check-o"></i> Joined - <?php $seminarid = $seminar->seminarid; $this->db->like('selectedseminarid', $seminarid); $this->db->from('seminarregistration'); echo $this->db->count_all_results(); ?></span></h5>
                            </div>
                        </div>
                    <?php } ?>
                    <?php } ?>
                </div>

            <?php } ?>
        </div>
    </div>
</div>
