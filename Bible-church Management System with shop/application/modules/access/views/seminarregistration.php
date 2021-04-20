
<div class="content access-page">
    <div class="col-md-12 error_message">
        <?php if ($this->session->flashdata('register_error')) { ?>
            <audio autoplay>
                <source src="<?php echo base_url(); ?>error.wav">
            </audio>

            <div class="alert alert-danger alert-with-icon" data-notify="container">
                <i class="material-icons" data-notify="icon">notifications</i>						
                <span data-notify="message"><?php echo $this->session->flashdata('register_error'); ?></span>
            </div>

        <?php } ?>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-md-offset-0 col-sm-offset-0">
                <img class="img-responsive logo" src="<?php echo base_url(); ?>assets/assets/images/website/<?php echo $basicinfo[0]->logo; ?>" alt="Logo">

                <form class="access-form" method="post" action="<?php echo base_url(); ?>dashboard/joinseminar/addnewapplicant" enctype="multipart/form-data">

                    <h5 class="text-center">Join Seminar</h5>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" onchange="previewFile()" name="profileimage" id="profileimage">
                            <input type="hidden" name="x" id="x">
                            <input type="hidden" name="y" id="y">
                            <input type="hidden" name="width" id="width">
                            <input type="hidden" name="height" id="height">
                        </div>
                    </div>    


                    <div class="col-md-6">
                        <div class="form-group">
                            <select id="selectedseminarid" name="selectedseminarid" class="select form-control" required>
                                <option value="">Select Seminar</option>
                                <?php foreach ($seminar_list as $slist) { ?>
                                    <option value="<?php echo $slist->seminarid; ?>"><?php echo word_limiter($slist->seminartitle, 6); ?> Duration Date - <?php echo $slist->seminarstart; ?> to <?php echo $slist->seminarend; ?></option>														
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="fname" name="fname" class="form-control" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="lname" name="lname" placeholder="Last Name"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select id="gender" name="gender" class="select form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="phone" name="phone" placeholder="Phone"  class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Email"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="age" name="age" placeholder="Age"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="education" name="education" placeholder="Education"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="church" name="church" placeholder="Church"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="churchpastor" name="churchpastor" placeholder="Church Pastor"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="guardian" name="guardian" placeholder="Guardian"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="guardiancontact" name="guardiancontact" placeholder="Guardian Contact"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="nationality" name="nationality" placeholder="Nationality"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select id="paymentgateway" name="paymentgateway" class="select form-control ">
                                <option value="">Select Payment Gateway</option>
                                <option value="Bkash">Bkash</option>
                                <option value="Paypal">Paypal</option>
                                <option value="Bank">Bank</option>
                                <option value="Credit/Debit Card">Credit/Debit Card</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="paymentgetwayinfo" name="paymentgetwayinfo" placeholder="Transaction ID" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="paymentsenderinfo" name="paymentsenderinfo" placeholder="Sender Info" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea rows="2" type="text" id="address" name="address" placeholder="Address"  class="form-control textarea"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="city" name="city" placeholder="City"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="country" name="country" placeholder="Country"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="postal" name="postal" placeholder="Postal"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="fname" name="facebook" placeholder="Facebook"  class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="fname" name="twitter" placeholder="Twitter"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="lname" name="googleplus" placeholder="Google Plus"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="position" name="linkedin" placeholder="Linkedin" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="fname" name="youtube" placeholder="Youtube"  class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="fname" name="pinterest" placeholder="Pinterest"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="lname" name="instagram" placeholder="Instagram"  class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="position" name="whatsapp" placeholder="Whatsapp"  class="form-control">
                        </div>
                    </div>

                    <div class="col-md-offset-3 col-md-6">
                        <button type="submit" class="btn btn-primary">Join Seminar</button>
                        <a href="<?php echo base_url(); ?>access/login" class="btn btn-primary off-focus">Login</a>
                        <a href="<?php echo base_url(); ?>dashboard/joinseminar" class="btn btn-primary off-focus">Signup</a>
                    </div>
                    
                    <div class="separator-container">
                        <div class="extra-space"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
