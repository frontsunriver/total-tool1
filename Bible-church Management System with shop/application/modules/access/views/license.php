
<div class="content access-page">
    <div class="col-md-offset-8 col-md-4 error_message mt-20">
        <?php if ($this->session->flashdata('error')) { ?>
            <audio autoplay>
                <source src="<?php echo base_url(); ?>assets/assets/error.wav">
            </audio>

            <div class="alert alert-danger alert-with-icon alert-dismissible" data-notify="container">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="material-icons" data-notify="icon">notifications</i>						
                <span data-notify="message"><?php echo $this->session->flashdata('error'); ?></span>
            </div>

        <?php } ?>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 mb-50">
                <img class="img-responsive logo" src="<?php echo base_url(); ?>assets/assets/images/website/<?php echo $basicinfo[0]->logo; ?>" alt="Logo">

                <form class="access-form" method="post" action="<?php echo base_url(); ?>access/license/insertLicense">

                    <h2 class="text-center" style="color:red;font-weight:bold">Please Verify Your License</h2>
                    <h4 class="text-center" style="color:red"><a href="https://codecanyon.net/item/bible-church-management-system/20615578" target="_blank" style="color:red; text-decoration:underline;font-weight:bold">For Awesome Support & Regular Updates Purchase A License</a></h4>
                    
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Enter Envato Username" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="code" class="form-control" placeholder="Enter Purchase Code" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="date" class="form-control" placeholder="Enter Purchase Date" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo base_url();?>access/logout" class="btn btn-primary off-focus">Logout</a>

                    <div class="separator-container">
                        <div class="extra-space"></div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
