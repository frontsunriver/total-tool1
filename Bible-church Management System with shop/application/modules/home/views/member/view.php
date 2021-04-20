
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url(); ?>home/member">Member</a></p>
            <h2>Member</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>

            <?php foreach ($member as $member) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="person-view">
                        <div class="row">
                            <img src="<?php echo base_url(); ?>assets/assets/images/member/profile/<?php echo $member->profileimage; ?>" alt="Member - <?php echo $member->fname . " " . $member->lname; ?>"></img>
                            <h5><?php echo $member->position; ?></h5>
                            <h4><a   href="<?php echo base_url(); ?>home/member/view/<?php echo $member->memberid; ?>"><?php echo $member->fname . " " . $member->lname; ?></a></h4>
                        </div>
                        
                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="social_media">
                                    <a class="socialbtn facebook" target="_blank" href="<?php echo $member->facebook; ?>"><i class="fa fa-facebook"></i></a>
                                    <a class="socialbtn twitter" target="_blank" href="<?php echo $member->twitter; ?>"><i class="fa fa-twitter"></i></a>
                                    <a class="socialbtn linkedin" target="_blank" href="<?php echo $member->linkedin; ?>"><i class="fa fa-linkedin"></i></a>
                                    <a class="socialbtn googleplus" target="_blank" href="<?php echo $member->googleplus; ?>"><i class="fa fa-google"></i></a>
                                    <a class="socialbtn youtube" target="_blank" href="<?php echo $member->youtube; ?>"><i class="fa fa-youtube"></i></a>
                                    <a class="socialbtn pinterest" target="_blank" href="<?php echo $member->pinterest; ?>"><i class="fa fa-pinterest"></i></a>
                                    <a class="socialbtn instagram" target="_blank" href="<?php echo $member->instagram; ?>"><i class="fa fa-instagram"></i></a>
                                    <a class="socialbtn whatsapp" target="_blank" href="tel:<?php echo $member->whatsapp; ?>"><i class="fa fa-whatsapp"></i></a>
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
                                            <td><?php echo $member->phone; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-heart"></i></td>
                                            <td>Blood Group</td>
                                            <td><?php echo $member->blood; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-envelope"></i></td>
                                            <td>Email</td>
                                            <td><?php echo $member->email; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar"></i></td>                                
                                            <td>DOB</td>
                                            <td><?php echo $member->dob; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar"></i></td>
                                            <td>Baptized</td>
                                            <td><?php echo $member->bpdate; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar"></i></td>
                                            <td>Marriage Date</td>
                                            <td><?php echo $member->marriagedate; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><i class="fa fa-book"></i></td>
                                            <td>Social Status</td>
                                            <td><?php echo $member->socialstatus; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-briefcase"></i></td>
                                            <td>Employment/Job</td>
                                            <td><?php echo $member->job; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><i class="fa fa-group"></i></td>
                                            <td>Family</td>
                                            <td><?php echo $member->family; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><i class="fa fa-th"></i></td>
                                            <td>Department</td>
                                            <td><?php echo $member->department; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i></td>
                                            <td>Nationality</td>
                                            <td><?php echo $member->nationality; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i></td>
                                            <td>Location</td>
                                            <td><?php echo $member->city . ", " . $member->country; ?></td>
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
                                    &q=<?php echo $member->city . ", " . $member->country; ?>">
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