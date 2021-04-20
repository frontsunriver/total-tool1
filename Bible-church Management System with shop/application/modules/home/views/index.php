
<div class="title_section">
    <?php foreach ($basicinfo as $basic)  ?>
    <div class="col-md-12 col-sm-12 col-xs-12 jamboo_title">
        <h1><?php echo $basic->title; ?></h1>
        <p class="sologan"><?php echo $basic->tag; ?></p>
    </div>

</div>

<div class="slider_section">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php $i = ""; foreach ($slider as $slide) { $i++; ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i-1;?>" <?php if($i == 1){?> class="active" <?php } ?>></li>
                <?php } ?>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php $i=0; foreach ($slider as $slide) { $i++;?>
                    <div class="item <?php if($i == 1){echo "active";} ?>">
                        <img src="<?php echo base_url();?>assets/assets/images/website/slider/<?php echo $slide->filename; ?>" alt="Slider Image">
                    </div>
                <?php } ?>
            </div>
        </div>
</div>
<div class="wrapper_section">

    <?php foreach ($event as $event): ?>
        <div class="next_event_sector">
            <p class="level">Upcoming Event - <a style="color:#fff" href="<?php echo base_url(); ?>home/event/view/<?php echo $event->eventid; ?>"><?php echo $event->eventtitle; ?></a></p>
            <p id="countdown_clock"></p>
            <p class="buttons"><a href="<?php echo base_url(); ?>home/event/view/<?php echo $event->eventid; ?>" class="">Read More</a><a href="<?php echo base_url(); ?>home/event" class="">All Events</a></p>
        </div>
    <?php endforeach; ?>

    <div class="donation_sector">
        <h3><?php echo $basic->donationtext; ?></h3>
        <a class="donate_now" data-toggle="modal" data-target="#donationModal"><i class="fa fa-heart"></i> Donate Now</a>

        <!-- Modal -->
        <div class="modal fade" id="donationModal" tabindex="-1" role="dialog" aria-labelledby="donationModal" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <h3 class="modal-title" id="donationModalLabel"><i class="fa fa-heart"></i> Donate Now</h3>
                </div>
              <div class="modal-body">

              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title text-center">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Paypal
                        </a>
                    </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">                        
                        <div class="row">
                            <div class="col-md-12">
                                <form  action="<?php echo base_url();?>dashboard/donation/paypal" method="post" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="number" min="5" class="form-control" name="amount" placeholder="Amount (Min $5) *" required>
                                        </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Your Name *" required>
                                        </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Your Email *" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <input type="text" class="form-control" name="phone" placeholder="Your Phone *" required>
                                            </div>
                                        </div>

                                        <div class="col-md-offset-4 col-md-6">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-heart"></i> Donate By Paypal</button>
                                        </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Stripe
                        </a>
                    </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                    <div class="row">
                      <div class="col-md-12">
                          <form action="<?php echo base_url();?>dashboard/donation/stripe" method="post" class="stripe-form" id="payment-form" enctype="multipart/form-data">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="number" min="5" class="form-control" name="amount" placeholder="Amount (Min $5) *" required>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Your Name *" required>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Your Email *" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" placeholder="Your Phone *" required>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <p for="card-element">Credit or Debit Card</p>
                                    <div id="card-element">
                                      <!-- a Stripe Element will be inserted here. -->
                                    </div>
                                    <!-- Used to display form errors -->
                                    <div id="card-errors"></div>
                                </div>

                                <div class="col-md-offset-4 col-md-6">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-heart"></i> Donate By Stripe</button>
                                </div>

                          </form>
                      </div>
                  </div>
                    </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Paystack
                        </a>
                    </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                    <div class="row">
                            <div class="col-md-12">
                                <form  action="<?php echo base_url();?>dashboard/donation/paystack" method="post" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="number" min="5" class="form-control" name="amount" placeholder="Amount (Min $5) *" required>
                                        </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Your Name *" required>
                                        </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Your Email *" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <input type="text" class="form-control" name="phone" placeholder="Your Phone *" required>
                                            </div>
                                        </div>

                                        <div class="col-md-offset-4 col-md-6">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-heart"></i> Donate By Paystack</button>
                                        </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
              </div>
            </div>
          </div>
        </div>

    </div>


    <!-- <div class="container"> -->

    <?php foreach ($section as $section) { ?>
        <?php if($section->sectiononoff == "Yes"){ ?>
            <div class="cs_sections <?php if ($section->background) { echo "parallax"; } ?>" data-parallax="scroll" data-image-src="assets/assets/images/section/crop/<?php echo $section->background; ?>">
                <div class="content">
                    <div class="container">
                        <h2><?php echo $section->title; ?></h2>
                        <div class="separator-container">
                            <div class="separator line-separator">♦</div>
                        </div>

                        <?php if ($section->shortcode) {
                            $SCAttArray = explode(",", $section->shortcode);
                            echo shortCode($SCAttArray[0], $SCAttArray[1], $SCAttArray[2], $SCAttArray[3], $SCAttArray[4]);
                        } ?>

                        <div class="col-md-offset-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <p><?php echo $section->content; ?></p>
                            <?php if ($section->link) { ?>
                                <div class="col-lg-offset-5 col-md-offset-5 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <a class="read_more" href="<?php echo $section->link; ?>"><?php echo $section->btntext; ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>



    <?php } ?>

    <div class="cs_sections information_desk">
        <div class="content">
        <div class="container">
            <h2>Information Desk</h2>

            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab" role="tablist">
                    <li role="presentation" class="active"><a href="#event" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-calendar fa-fw"></i> Events</a></li>
                    <li role="presentation"><a href="#church_time" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-clock-o fa-fw"></i> Church Time</a></li>
                    <li role="presentation"><a href="#prayer_request" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-microphone fa-fw"></i> Prayer Request</a></li>
                    <li role="presentation"><a href="#notice" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-tags fa-fw"></i> Notice</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="event">
                        <div class="event_body">
                            <div id="calendar"></div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="church_time">
                        <div class="event_body">
                                <div class="event_content">
                                    <h4><i class="fa fa-clock-o fa-fw"></i> Church Time Schedule</h4>
                                    <p class="elements"><?php echo $basic->churchtime; ?></p>
                                </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="prayer_request">
                        <div class="event_body">
                                <?php $i = 0; foreach ($prayer as $prayer) { $i++; ?>
                                    <div class="event_content">
                                        <h4><i class="fa fa-microphone fa-fw"></i> <?php echo $prayer->prayertitle; ?> <span class="btn"><a href="<?php echo base_url();?>home/prayer/view/<?php echo $prayer->prayerid; ?>">View</a></span></h4>
                                        <p class="elements"><?php echo $prayer->prayerdescription; ?></p>
                                    </div>
                                    <?php if ($i == 3) { break;}
                                } ?>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="notice">
                        <div class="event_body">
                                <?php $i = 0; foreach ($notice as $notice) { $i++; ?>
                                    <div class="event_content">
                                        <h4><i class="fa fa-microphone fa-fw"></i> <?php echo $notice->noticetitle; ?> <span class="btn"><a href="<?php echo base_url();?>home/notice/view/<?php echo $notice->noticeid; ?>">View</a></span></h4>
                                        <p class="elements"><?php echo $notice->noticedescription; ?></p>
                                    </div>
                                    <?php if ($i == 3) { break; }
                                } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="cs_sections gallery">
        <div class="content">
            <div class="container">

                <h2>Gallery</h2>

                <div class="separator-container">
                    <div class="separator line-separator">♦</div>
                </div>

                <div class="col-md-offset-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="gallery" style="display:none;">
                        <?php foreach ($gallery as $gallery) { ?>
                            <img alt="<?php echo $gallery->filename; ?>" src="<?php echo base_url(); ?>assets/assets/images/website/gallery/small/<?php echo $gallery->filename; ?>"
                                 data-image="<?php echo base_url(); ?>assets/assets/images/website/gallery/large/<?php echo $gallery->filename; ?>"
                                 data-description="<?php echo $gallery->filename; ?>">
                             <?php } ?>
                    </div>
                </div>
                <div class="col-lg-offset-5 col-md-offset-5 col-lg-2 col-md-2 col-sm-12 col-xs-12"><a class="read_more" href="<?php echo base_url(); ?>home/gallery">View More</a></div>
            </div>
        </div>
    </div>

    <div class="cs_sections contact_with_us">
        <div class="content">
        <div class="container">
            <h2>Contact With Us</h2>

            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <form id="contactform" class="form-horizontal" action="<?php echo base_url();?>home/home/contactWithUs" method="post" enctype="multipart/form-data">
                    <div class="column one-second">
                        <input placeholder="Your name" type="text" name="name" required>
                    </div>
                    <div class="column one-second">
                        <input placeholder="Your e-mail" type="email" name="email" required>
                    </div>
                    <div class="column one">
                        <input placeholder="Subject" type="text" name="subject" id="subject" required>
                    </div>
                    <div class="column one">
                        <textarea placeholder="Message" name="body" id="body" style="width:100%;" rows="10" required></textarea>
                    </div>
                    <div class="column one">
                        <input type="submit" value="Send Now" id="submit" >
                    </div>
                </form>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <iframe style="margin-top: 2%;"
                    width="100%"
                    height="400"
                    frameborder="0" style="border:0; pointer-events: none;"
                    src="https://www.google.com/maps/embed/v1/place?key=<?php echo getBasic()->mapapi;?>&q=<?php echo $basic->map; ?>" allowfullscreen>
                </iframe>
            </div>

        </div>
        </div>
    </div>
