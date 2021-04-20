
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/staff">Staff</a></p>
            <h2>Staff</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($staff as $staff) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="person-view">
                        <div class="row">
                            <img src="<?php echo base_url(); ?>assets/assets/images/staff/profile/<?php echo $staff->profileimage; ?>" alt="Staff - <?php echo $staff->fname . " " . $staff->lname; ?>"></img>
                            <h5><?php echo $staff->position; ?></h5>
                            <h4><a   href="<?php echo base_url(); ?>home/staff/view/<?php echo $staff->staffid; ?>"><?php echo $staff->fname . " " . $staff->lname; ?></a></h4>

                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="social_media">
                                    <a class="socialbtn facebook" target="_blank" href="<?php echo $staff->facebook; ?>"><i class="fa fa-facebook"></i></a>
                                    <a class="socialbtn twitter" target="_blank" href="<?php echo $staff->twitter; ?>"><i class="fa fa-twitter"></i></a>
                                    <a class="socialbtn linkedin" target="_blank" href="<?php echo $staff->linkedin; ?>"><i class="fa fa-linkedin"></i></a>
                                    <a class="socialbtn googleplus" target="_blank" href="<?php echo $staff->googleplus; ?>"><i class="fa fa-google"></i></a>
                                    <a class="socialbtn youtube" target="_blank" href="<?php echo $staff->youtube; ?>"><i class="fa fa-youtube"></i></a>
                                    <a class="socialbtn pinterest" target="_blank" href="<?php echo $staff->pinterest; ?>"><i class="fa fa-pinterest"></i></a>
                                    <a class="socialbtn instagram" target="_blank" href="<?php echo $staff->instagram; ?>"><i class="fa fa-instagram"></i></a>
                                    <a class="socialbtn whatsapp" target="_blank" href="tel:<?php echo $staff->whatsapp; ?>"><i class="fa fa-whatsapp"></i></a>
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
                                            <td><?php echo $staff->phone; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-heart"></i></td>
                                            <td>Blood Group</td>
                                            <td><?php echo $staff->blood; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-envelope"></i></td>
                                            <td>Email</td>
                                            <td><?php echo $staff->email; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-user"></i></td>                                
                                            <td>Gender</td>
                                            <td><?php echo $staff->gender; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar"></i></td>                                
                                            <td>Birthday</td>
                                            <td><?php echo $staff->dob; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar"></i></td>
                                            <td>Baptized</td>
                                            <td><?php echo $staff->bpdate; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar"></i></td>
                                            <td>Marriage Date</td>
                                            <td><?php echo $staff->marriagedate; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><i class="fa fa-book"></i></td>
                                            <td>Social Status</td>
                                            <td><?php echo $staff->socialstatus; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-briefcase"></i></td>
                                            <td>Employment/Job</td>
                                            <td><?php echo $staff->job; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><i class="fa fa-group"></i></td>
                                            <td>Family</td>
                                            <td><?php echo $staff->family; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><i class="fa fa-th"></i></td>
                                            <td>Department</td>
                                            <td><?php echo $staff->department; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-briefcase"></i></td>
                                            <td>Position</td>
                                            <td><?php echo $staff->position; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i></td>
                                            <td>Nationality</td>
                                            <td><?php echo $staff->nationality; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i></td>
                                            <td>Location</td>
                                            <td><?php echo $staff->city . ", " . $staff->country; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <iframe
                                    width="100%"
                                    height="280"
                                    frameborder="0" style="border:0; pointer-events: none;"
                                    src="https://www.google.com/maps/embed/v1/place?key=<?php echo getBasic()->mapapi;?>
                                    &q=<?php echo $staff->city . ", " . $staff->country; ?>">
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