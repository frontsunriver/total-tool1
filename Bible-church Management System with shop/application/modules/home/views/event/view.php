
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/event">Event</a></p>
            <h2>Event</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($event as $event) { ?>
                <div class="col-md-8">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="seminar single">
                            <img src="<?php echo base_url(); ?>assets/assets/images/event/feature/<?php echo $event->eventimage; ?>" alt="Event Banner"></img>
                            <h5><span><i class="fa fa-calendar"></i> Time - <?php echo $event->eventtime; ?>, <?php echo $event->eventdate; ?></span> <span><i class="fa fa-map-marker"></i> Location - <?php echo $event->eventlocation; ?></span> </h5>
                            <h4><a href="<?php echo base_url(); ?>home/event/view/<?php echo $event->eventid; ?>"><?php echo $event->eventtitle; ?></a></h4>
                        </div>

                        <div class="seminar-view">
                            <div class="row">
                                <h4><?php echo $event->eventdescription; ?></h4>
                            </div>

                            <div class="separator-container">
                                <div class="extra_space_sm"></div>
                            </div>

                            <?php if(!empty($event->eventlocation)){ ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <iframe
                                            width="100%"
                                            height="300"
                                            frameborder="0" style="border:0; pointer-events: none;"
                                            src="https://www.google.com/maps/embed/v1/place?key=<?php echo getBasic()->mapapi;?>
                                            &q=<?php echo $event->eventlocation; ?>">
                                        </iframe>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="row">
                            <h4 data-toggle="modal" data-target=".bs-example-modal-lg" class="text-center"><a class="text-center btn btn-lg btn-primary registerButton" href="#">Register Now</a></h4>
                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="socialShare"></div>
                        </div>

                    </div>
                </div>


                <div id="eventRegisterModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <!-- <form  action="<?php echo base_url();?>dashboard/event/registration" method="post" enctype="multipart/form-data">



                        </form> -->
                        <form class="access-form" method="post" action="<?php echo base_url(); ?>dashboard/event/registration/">

                            <h4 class="text-center"> Event Registration </h4>
                            <input type="hidden" name="eventid" value="<?php echo $event->eventid; ?>">

                            <div class="col-md-6">
                                <label for="">First Name</label>
                                <div class="form-group">
                                    <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Last Name</label>
                                <div class="form-group">
                                    <input type="text" name="lname" placeholder="Last Name"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Email</label>
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Email"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Phone</label>
                                <div class="form-group">
                                    <input type="text" name="phone" placeholder="Phone"  class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Gender</label>
                                <div class="form-group">
                                    <select name="gender" class="select form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Date of Birth</label>
                                <div class="form-group">
                                    <input type="date" name="birthdate" placeholder=" Date of Birth "  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Nationality</label>
                                <div class="form-group">
                                    <input type="text" name="nationality" placeholder="Nationality"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Address</label>
                                <div class="form-group">
                                    <input type="text" name="address" placeholder="Address"  class="form-control ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">City</label>
                                <div class="form-group">
                                    <input type="text" name="city" placeholder="City"  class="form-control">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label for="">Country</label>
                                <div class="form-group">
                                    <input type="text" name="country" placeholder="Country"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Postal</label>
                                <div class="form-group">
                                    <input type="text" name="postal" placeholder="Postal"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for=""> Participant Type </label>
                                <div class="form-group">
                                    <select name="participanttype" class="select form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="Qulified">Qulified</option>
                                        <option value="Aids">Aids</option>
                                        <option value="Guests">Guests</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-offset-5 col-md-6">
                                <button type="submit" class="btn btn-primary">Register Now</button>
                            <div class="separator-container">
                                <div class="extra-space"></div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>


            </div>

            <?php } ?>

                <div class="col-md-4">
                    <?php if( is_array($recents) ){ ?>
                        <?php foreach ($recents as $recent){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="seminar">
                                <img src="<?php echo base_url();?>assets/assets/images/event/feature/<?php echo $recent->eventimage;?>" alt="Event Banner"></img>
                                <h5><span><i class="fa fa-calendar"></i> Time - <?php echo $recent->eventtime;?>, <?php echo $recent->eventdate;?></span> <span><i class="fa fa-map-marker"></i> Location - <?php echo $recent->eventlocation;?></span></h5>
                                <h4><a   href="<?php echo base_url();?>home/event/view/<?php echo $recent->eventid;?>"><?php echo $recent->eventtitle;?></a></h4>
                            </div>
                        </div>
                        <?php } ?>
                    <?php }?>
                </div>
        </div>


</div>
