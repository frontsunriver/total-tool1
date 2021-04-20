
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/sermon">Sermon</a></p>
            <h2>Sermon</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($sermon as $sermon) { ?>
                <div class="col-md-8">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="seminar single">
                            <img src="<?php echo base_url(); ?>assets/assets/images/sermon/feature/<?php echo $sermon->sermonbanner; ?>" alt="Sermon Banner"></img>
                            <h5><span><i class="fa fa-calendar"></i> Time - <?php echo $sermon->sermontime; ?>, <?php echo $sermon->sermondate; ?></span> <span><i class="fa fa-map-person"></i> Pastor/Writer/Author - <?php echo $sermon->sermonauthor; ?></span> <span><i class="fa fa-map-marker"></i> Location - <?php echo $sermon->sermonlocation; ?></span> </h5>
                            <h4><a   href="<?php echo base_url(); ?>home/sermon/view/<?php echo $sermon->sermonid; ?>"><?php echo $sermon->sermontitle; ?></a></h4>
                        </div>

                        <div class="col-md-offset-3 col-md-6">
                            <div class="sermon social_media">
                                <?php if(!empty($sermon->sermonyoutube)){ ?>
                                    <a title="Youtube Video" class="socialbtn youtube" target="_blank" href="<?php echo $sermon->sermonyoutube; ?>"><i class="fa fa-youtube"></i></a>
                                <?php } ?>
                                <?php if(!empty($sermon->sermonsoundcloud)){ ?>
                                    <a title="Sound Cloud Audio" class="socialbtn twitter" target="_blank" href="<?php echo $sermon->sermonsoundcloud; ?>"><i class="fa fa-music"></i></a>
                                <?php } ?>
                                <?php if(!empty($sermon->video)){ ?>
                                    <a title="Video" class="socialbtn twitter" target="_blank" href="<?php echo base_url('video/sermon/') . $sermon->video; ?>"><i class="fa fa-video-camera"></i></a>
                                <?php } ?>
                                <?php if(!empty($sermon->audio)){ ?>
                                    <a title="Audio" class="socialbtn twitter" target="_blank" href="<?php echo base_url('audio/sermon/') . $sermon->audio; ?>"><i class="fa fa-music"></i></a>
                                <?php } ?>
                                <?php if(!empty($sermon->file)){ ?>
                                    <a title="File" class="socialbtn twitter" target="_blank" href="<?php echo base_url('files/') . $sermon->file; ?>"><i class="fa fa-file"></i></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="seminar-view">

                            <div class="row">
                                <h4><?php echo $sermon->sermondescription; ?></h4>
                            </div>


                            <?php if(!empty($sermon->video)){ ?>
                                <div class="row">

                                    <div class="separator-container">
                                        <div class="extra_space_sm"></div>
                                    </div>

                                    <div class="single-sermon-video-div">
                                        <video class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" controls preload="auto" width="740" height="364"
                                        poster="<?php echo base_url(); ?>assets/assets/images/sermon/feature/<?php echo $sermon->sermonbanner; ?>" data-setup='{"fluid": true}'>
                                          <source src="<?php echo base_url(); ?>video/sermon/<?php echo $sermon->video;?>" type="video/mp4">
                                          <source src="<?php echo base_url(); ?>video/sermon/<?php echo $sermon->video;?>" type="video/webm">
                                          <p class="vjs-no-js">
                                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                                            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                          </p>
                                        </video>
                                    </div>


                                </div>
                            <?php  } ?>


                            <div class="separator-container">
                                <div class="extra_space_sm"></div>
                            </div>

                            <?php if(!empty($sermon->sermonlocation)){ ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <iframe
                                            width="100%"
                                            height="300"
                                            frameborder="0" style="border:0; pointer-sermons: none;"
                                            src="https://www.google.com/maps/embed/v1/place?key=<?php echo getBasic()->mapapi;?>
                                            &q=<?php echo $sermon->sermonlocation; ?>">
                                        </iframe>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="socialShare"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <?php if( is_array($recents) ){ ?>
                    <?php foreach ($recents as $recent){ ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="seminar">
                            <img src="<?php echo base_url();?>assets/assets/images/sermon/feature/<?php echo $recent->sermonbanner;?>" alt="<?php echo $recent->sermontitle;?>">
                            <h5><span class="elements">Time - <?php echo $recent->sermontime; ?> | Date - <?php echo $recent->sermondate; ?> | Pastor/Writer/Author - <?php echo $recent->sermonauthor; ?></span></h5>
                            <h4><a href="<?php echo base_url();?>home/sermon/view/<?php echo $recent->sermonid;?>"><?php echo $recent->sermontitle; ?></a></h4>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                </div>

            <?php } ?>
        </div>
    </div>
</div>
