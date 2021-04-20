<?php foreach ($individual as $row): ?>
    <div class="content">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title" style="color:#fff"><i class="material-icons">flare</i> Update Applicant</h4>
                            <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                        </div>
                        <div class="card-content">

                            <form id="updateSeminarRegForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/joinseminar/addnewapplicant" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-6">
                                        <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>assets/assets/images/upload.png);">
                                            <img id="image" src="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_spp'); ?></p>
                                            <input type="file" onchange="previewFile()" name="profileimage" id="profileimage">
                                            <input type="hidden" name="x" id="x">
                                            <input type="hidden" name="y" id="y">
                                            <input type="hidden" name="width" id="width">
                                            <input type="hidden" name="height" id="height">
                                        </div>
                                    </div>


                                    <div class="col-md-6 destroy_cropper_div">
                                    	<div class="form-group label-floating">
                                    		<p class="image_select_text destroy_cropper"><i class="material-icons">crop</i> <?php echo $this->lang->line('dash_gpanel_clear_crop'); ?></p>
                                    	</div>
                                    </div>

                                    <div class="col-md-6 ini_cropper_div" style="display:none">
                                    	<div class="form-group label-floating">
                                    		<p class="image_select_text ini_cropper"><i class="material-icons">crop</i> <?php echo $this->lang->line('dash_gpanel_ini_crop'); ?></p>
                                    	</div>
                                    </div>
                                </div>

                                <input type="hidden" name="seminarregid" id="seminarregid" value="<?php echo $row->seminarregid; ?>">

                                <div class="row">
                                    <div class="col-md-offset-0 col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Select Seminar You Want To Be Join (*)</label>
                                            <select id="selectedseminarid" name="selectedseminarid" class="select form-control" required>
                                                <option value="">Select Seminar</option>
                                                <option selected value="<?php echo $row->selectedseminarid; ?>"><?php echo $seminartitle; ?> Cureent)</option>
                                                <?php foreach ($seminar_list as $slist) { ?>
                                                    <option value="<?php echo $slist->seminarid; ?>"><?php echo word_limiter($slist->seminartitle, 6); ?> (<?php echo $slist->seminarstart; ?> to <?php echo $slist->seminarend; ?>)</option>
                                                <?php } ?>
                                            </select>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">First Name (*)</label>
                                            <input type="text" id="fname" name="fname" class="form-control" value="<?php echo $row->fname; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Last Name</label>
                                            <input type="text" id="lname" name="lname" class="form-control" value="<?php echo $row->lname; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Gender (*)</label>
                                            <!-- <input type="text" id="gender" name="gender" class="form-control"> -->
                                            <select id="gender" name="gender" class="select form-control" required>
                                                <option value="">Select Gender</option>
                                                <option selected value="<?php echo $row->gender; ?>"><?php echo $row->gender; ?> (Current)</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Phone (*)</label>
                                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $row->phone; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $row->email; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Age</label>
                                            <input type="text" id="age" name="age" class="form-control" value="<?php echo $row->age; ?>">
                                            <span class="material-input"></span></div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Education Level</label>
                                            <input type="text" id="education" name="education" class="form-control" value="<?php echo $row->education; ?>">
                                            <span class="material-input"></span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Church</label>
                                            <input type="text" id="church" name="church" class="form-control" value="<?php echo $row->church; ?>">
                                            <span class="material-input"></span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Church Pastor</label>
                                            <input type="text" id="churchpastor" name="churchpastor" class="form-control" value="<?php echo $row->churchpastor; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Guardian</label>
                                            <input type="text" id="guardian" name="guardian" class="form-control" value="<?php echo $row->guardian; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Guardian Contact Number</label>
                                            <input type="text" id="guardiancontact" name="guardiancontact" class="form-control" value="<?php echo $row->guardiancontact; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Nationality</label>
                                            <input type="text" id="nationality" name="nationality" class="form-control" value="<?php echo $row->nationality; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Desire Payment Gateway</label>
                                            <select id="paymentgateway" name="paymentgateway" class="select form-control">
                                                <option selected value="<?php echo $row->paymentgateway; ?>"><?php echo $row->paymentgateway; ?></option>
                                                <option value="Bkash">Bkash</option>
                                                <option value="Paypal">Paypal</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Credit/Debit Card">Credit/Debit Card</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Payment Transaction ID/Info</label>
                                            <input type="text" id="paymentgetwayinfo" name="paymentgetwayinfo" placeholder="ex: Bkash Transaction ID" class="form-control" value="<?php echo $row->paymentgatewayinfo; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Payment Sender Number/Info</label>
                                            <input type="text" id="paymentsenderinfo" name="paymentsenderinfo" placeholder="ex: Bkash Sender Number" class="form-control" value="<?php echo $row->paymentsenderinfo; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Address</label>
                                            <textarea rows="5" type="text" id="address" name="address" class="form-control"><?php echo $row->address; ?></textarea>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">City</label>
                                            <input type="text" id="city" name="city" class="form-control" value="<?php echo $row->city; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Country</label>
                                            <input type="text" id="country" name="country" class="form-control" value="<?php echo $row->country; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Postal/Zone</label>
                                            <input type="text" id="postal" name="postal" class="form-control" value="<?php echo $row->postal; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_facebook'); ?></label>
                                            <input type="text" id="fname" name="facebook" class="form-control" value="<?php echo $row->facebook; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_twitter'); ?></label>
                                            <input type="text" id="fname" name="twitter" class="form-control" value="<?php echo $row->twitter; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_googleplus'); ?></label>
                                            <input type="text" id="lname" name="googleplus" class="form-control" value="<?php echo $row->googleplus; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_linkedin'); ?></label>
                                            <input type="text" id="position" name="linkedin" class="form-control" value="<?php echo $row->linkedin; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_youtube'); ?></label>
                                            <input type="text" id="fname" name="youtube" class="form-control" value="<?php echo $row->youtube; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pinterest'); ?></label>
                                            <input type="text" id="fname" name="pinterest" class="form-control" value="<?php echo $row->pinterest; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_instagram'); ?></label>
                                            <input type="text" id="lname" name="instagram" class="form-control" value="<?php echo $row->instagram; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_whatsapp'); ?></label>
                                            <input type="text" id="position" name="whatsapp" class="form-control" value="<?php echo $row->whatsapp; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <button id="updateSeminarRegSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> Update Applicant</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
