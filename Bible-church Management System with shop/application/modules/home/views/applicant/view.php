
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/applicant">Applicant</a></p>
            <h2>Applicant</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($applicant as $applicant) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="person-view">
                        <div class="row">
                            <img src="<?php echo base_url(); ?>assets/assets/images/seminar/profile/<?php echo $applicant->profileimage; ?>" alt="Applicant - <?php echo $applicant->fname . " " . $applicant->lname; ?>"></img>
                            <h5><?php echo $applicant->church; ?></h5>
                            <h4><a   href="<?php echo base_url(); ?>home/applicant/view/<?php echo $applicant->seminarregid; ?>"><?php echo $applicant->fname . " " . $applicant->lname; ?></a></h4>
                            <!--<p><?php echo strip_tags($applicant->speech); ?></p>-->
                        </div>
                        
                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="social_media">
                                    <a class="socialbtn facebook" target="_blank" href="<?php echo $applicant->facebook; ?>"><i class="fa fa-facebook"></i></a>
                                    <a class="socialbtn twitter" target="_blank" href="<?php echo $applicant->twitter; ?>"><i class="fa fa-twitter"></i></a>
                                    <a class="socialbtn linkedin" target="_blank" href="<?php echo $applicant->linkedin; ?>"><i class="fa fa-linkedin"></i></a>
                                    <a class="socialbtn googleplus" target="_blank" href="<?php echo $applicant->googleplus; ?>"><i class="fa fa-google"></i></a>
                                    <a class="socialbtn youtube" target="_blank" href="<?php echo $applicant->youtube; ?>"><i class="fa fa-youtube"></i></a>
                                    <a class="socialbtn pinterest" target="_blank" href="<?php echo $applicant->pinterest; ?>"><i class="fa fa-pinterest"></i></a>
                                    <a class="socialbtn instagram" target="_blank" href="<?php echo $applicant->instagram; ?>"><i class="fa fa-instagram"></i></a>
                                    <a class="socialbtn whatsapp" target="_blank" href="tel:<?php echo $applicant->whatsapp; ?>"><i class="fa fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="row">    
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td><i class="fa fa-phone"></i></td>
                                            <td>Phone</td>
                                            <td><?php echo $applicant->phone; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-envelope"></i></td>
                                            <td>Email</td>
                                            <td><?php echo $applicant->email; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-male"></i></td>
                                            <td>Gender</td>
                                            <td><?php echo $applicant->gender; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar"></i></td>
                                            <td>Age</td>
                                            <td><?php echo $applicant->age; ?> Years Old</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-graduation-cap"></i></td>
                                            <td>Education</td>
                                            <td><?php echo $applicant->education; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-handshake-o"></i></td>
                                            <td>Church</td>
                                            <td><?php echo $applicant->church; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-male"></i></td>
                                            <td>Church Pastor</td>
                                            <td><?php echo $applicant->churchpastor; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-male"></i></td>
                                            <td>Guardian</td>
                                            <td><?php echo $applicant->guardian; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-phone"></i></td>
                                            <td>Guardian Contact</td>
                                            <td><?php echo $applicant->guardiancontact; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i></td>
                                            <td>Nationality</td>
                                            <td><?php echo $applicant->nationality; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i></td>
                                            <td>Location</td>
                                            <td><?php echo $applicant->city . ", " . $applicant->country; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <iframe
                                    width="100%"
                                    height="280"
                                    frameborder="0" style="border:0; pointer-events: none;"
                                    src="https://www.google.com/maps/embed/v1/place?key=<?php echo getBasic()->mapapi;?>&q=<?php echo $applicant->city . ", " . $applicant->country; ?>">
                                </iframe>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="separator-container">
                        <div class="extra_space_sm"></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
                        <div class="socialShare"></div>
                    </div>
                    
                </div>
            <?php } ?>
        </div>
    </div>
</div> 