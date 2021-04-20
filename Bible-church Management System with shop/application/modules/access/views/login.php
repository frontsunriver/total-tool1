
<div class="content access-page">
    <div class="col-md-offset-8 col-md-4 error_message mt-20">
        <?php if ($this->session->flashdata('login_error')) { ?>
            <audio autoplay>
                <source src="<?php echo base_url(); ?>assets/assets/error.wav">
            </audio>

            <div class="alert alert-danger alert-with-icon alert-dismissible" data-notify="container">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="material-icons" data-notify="icon">notifications</i>						
                <span data-notify="message"><?php echo $this->session->flashdata('login_error'); ?></span>
            </div>

        <?php } ?>

        <?php if ($this->session->flashdata('logout_msg')) { ?>
            <audio autoplay>
                <source src="<?php echo base_url(); ?>error.wav">
            </audio>

            <div class="alert alert-success alert-with-icon alert-dismissible" data-notify="container">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="material-icons" data-notify="icon">notifications</i>						
                <span data-notify="message"><?php echo $this->session->flashdata('logout_msg'); ?></span>
            </div>

        <?php } ?>

    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3 mb-50">
                <img class="img-responsive logo" src="<?php echo base_url(); ?>assets/assets/images/website/<?php echo $basicinfo[0]->logo; ?>" alt="Logo">

                <form class="access-form" method="post" action="<?php echo base_url(); ?>access/login/checking">

                    <h5 class="text-center">Social Login</h5>
                    <div class="social-line text-center">

                        <a href="<?php echo base_url(); ?>access/login/media/Facebook" class="btn btn-just-icon btn-simple">
                            <i class="fa fa-facebook-square"></i>
                            <div class="ripple-container"></div>
                        </a>

                        <a href="<?php echo base_url(); ?>access/login/media/Twitter" class="btn btn-just-icon btn-simple">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="<?php echo base_url(); ?>access/login/media/Google" class="btn btn-just-icon btn-simple">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </div>

                    <hr>

                    <h5 class="text-center">Classic Login</h5>

                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                        
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="<?php echo base_url();?>access/register" class="btn btn-primary off-focus">Signup</a>
                    <a href="<?php echo base_url();?>dashboard/joinseminar" class="btn btn-primary off-focus">Join Seminar</a>
                    
                    <div class="separator-container">
                        <div class="extra-space"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
