
<?php
if ($this->uri->uri_string() == '') {
    $home = true;
} else {
    $home = false;
}
?>

<?php

    $query = $this->db->get('websitebasic');
    foreach ($query->result() as $basic):
?>

<!DOCTYPE html>

<!--[if lt IE 7 ]><html class="no-js ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>assets/assets/images/website/<?php echo $basic->favicon;?>"/>
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $basic->title;?> | <?php echo $basic->tag;?></title>

        <!-- Bootstrap And Styles -->
        <link href="<?php echo base_url(); ?>assets/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/assets/css/animations.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/assets/css/normalize.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/assets/css/ionicons.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/assets/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" rel="stylesheet" />

        <link href="<?php echo base_url(); ?>assets/assets/css/owl.carousel.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/assets/css/owl.theme.default.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/assets/fullcalendar/fullcalendar.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/assets/fullcalendar/fullcalendar.print.min.css" rel="stylesheet" media="print" >

        <link href="<?php echo base_url(); ?>assets/assets/unitegallery/dist/css/unite-gallery.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/assets/unitegallery/dist/themes/default/ug-theme-default.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/assets/jssocials/jssocials.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/assets/jssocials/jssocials-theme-flat.css" rel="stylesheet" type="text/css" />


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


        <style>
            <?php $themeColor = $basic->color;?>

            a {
                color: <?php echo $themeColor; ?>;
            }

            .header_sec_bg {
                background: <?php echo $themeColor; ?> !important;
                position: relative !important;
            }

            .header_sec_bg .navbar-nav li ul li a:focus, .navbar-nav li ul li a:hover {
                color: <?php echo $themeColor; ?>
            }

/*            .header_section {
                background: <?php echo $themeColor; ?> !important;
            }*/

            .navbar-nav li ul li a:hover {
                color: <?php echo $themeColor; ?>;
                border-bottom:1px solid;
            }

            .allperson ul.pagination li.active a {
                background: <?php echo $themeColor; ?>;
            }

            .allperson ul.pagination li a {
                color: <?php echo $themeColor; ?>;
            }

            .person-view a.socialbtn, .footer a.socialbtn, .sermon a.socialbtn {
                background: <?php echo $themeColor; ?>;
                color: #fff;
            }

            .person-view a.socialbtn {
                background: <?php echo $themeColor; ?>;
                color: #fff;
            }

            .carousel-indicators .active {
                background-color: <?php echo $themeColor; ?> !important;
            }

            .cs_sections h2 {
                color: <?php echo $themeColor; ?>;
            }

            .separator:before, .separator:after {
                border: 1px solid <?php echo $themeColor; ?>;
            }

            .separator {
                color: <?php echo $themeColor; ?>;
            }

            .cs_sections .pastors h4 {
                color: <?php echo $themeColor; ?>;
            }

            .cs_sections .pastors a.read_more:hover {
                color: <?php echo $themeColor; ?> !important;
                border: 1px solid <?php echo $themeColor; ?> !important;
            }

            .owl-dots .owl-dot.active span, .owl-dots .owl-dot:hover span {
                background: <?php echo $themeColor; ?>;
            }

            .cs_sections .pastors a {
                color: <?php echo $themeColor; ?>;
            }

            blockquote {
                border-left: 5px solid <?php echo $themeColor; ?>;
            }

            ul.nav.nav-tabs.tab li.active a, ul.nav.nav-tabs.tab li a:hover {
                color: <?php echo $themeColor; ?>;
                background: rgba(255, 255, 255, 0);
            }

            .fc th {
                color: <?php echo $themeColor; ?>;
            }

            .fc-ltr .fc-basic-view .fc-day-top .fc-day-number {
                color: <?php echo $themeColor; ?>;
            }

            .fc-event, .fc-event-dot {
                background-color: <?php echo $themeColor; ?> !important;
            }

            .fc-unthemed td.fc-today {
                background: <?php echo $themeColor; ?> !important;
            }

            .column input#submit {
                background: <?php echo $themeColor; ?>;
            }

            .box {
                background: <?php echo $themeColor; ?>;
            }

            a.read_more {
                border: 1px solid <?php echo $themeColor; ?>;
                background: <?php echo $themeColor; ?>;
            }

            .prayer_request h4, .event h4, .church_time h4 {
                background: linear-gradient(60deg, <?php echo $themeColor; ?>, rgba(142, 36, 170, 0));
            }


            .donation_sector {
                background: <?php echo $themeColor; ?>;
            }


            .next_event_sector {
                background: <?php echo $themeColor; ?>;
            }

            .next_event_sector #countdown_clock {
                color: #fff;
            }

            .next_event_sector #countdown_clock span {
                background: #fff;
                color:<?php echo $themeColor; ?> !important;
            }

            .next_event_sector #countdown_clock span small {
                color:<?php echo $themeColor; ?> !important;
            }

            .next_event_sector p.buttons a {
                color: <?php echo $themeColor; ?> !important;
                border: 1px solid #fff !important;
                background: #fff !important;
            }

            .next_event_sector p.buttons a:hover {
                color: #fff !important;
                border: 1px solid #fff !important;
                background: <?php echo $themeColor; ?> !important;
            }

            .sermon .right .btn {
                background: <?php echo $themeColor; ?>;
            }

            .footer-below {
                background: <?php echo $themeColor; ?>;
            }


            .access-page .btn-primary {
                color: #fff;
                border-color: <?php echo $themeColor; ?>;
                background-color: <?php echo $themeColor; ?>;
            }


        </style>

    </head>
    <body>

        <div id="scroll-element" class="header_section <?php if ($home == false) { echo "header_sec_bg"; } ?>">
            <div class="container">
                <div class="col-md-1 col-sm-1 col-xs-1 logo">
                    <img src="<?php echo base_url();?>assets/assets/images/website/<?php echo $basic->logo;?>" alt="<?php echo $basic->title;?>"></img>
                </div>
                <div class="col-md-11 col-sm-11 col-xs-11">
                    <nav class="navbar primary">
                        <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                          <ul class="nav navbar-nav">
                            <?php

                            $this->db->where('menuparentid', " ");
                            $this->db->order_by('serialid', "ase");
                            $parentmenu = $query = $this->db->get('menu');
                            $parentmenu->result();

                            foreach ($parentmenu->result() as $row) { ?>
                              <?php
                                    $this->db->where('menuparentid', $row->menuid);
                                    $pmquery = $this->db->get('menu');
                              ?>

                              <li class="parent-menu">
                                  <a href="<?php if($row->menupageid){echo base_url('home/page'). "/". $row->menupageid;}else{echo $row->menulink;} ?>"><?php echo $row->menuname;?> <?php if( $pmquery->num_rows() > 0 ){ echo '<i class="fa-fw fa fa-angle-down"></i>'; } ?></a>
                                    <?php

                                        $this->db->where('serialid', $row->menuid);
                                        $this->db->order_by('subserialid', "ase");
                                        $cmquery = $this->db->get('menu');

                                        if($cmquery->num_rows() > 0){ ?>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($cmquery->result() as $cm) { ?>
                                                <li><a href="<?php echo $cm->menulink;?>"><?php echo $cm->menuname;?></a></li>
                                            <?php }?>
                                        </ul>
                                    <?php } ?>
                                </li>

                            <?php }  if($home == true){ ?>

                                <li class="parent-menu donation">
                                    <a data-toggle="modal" data-target="#donationModal"><i class="fa fa-heart"></i> Donate</a>
                                </li>

                            <?php } ?>

                            <?php

                            $this->db->where('cartUserID', $this->session->userdata('user_id'));
                            $this->db->where('cartcdate', date('j F Y'));
                            $status = array('Bought', 'Cancel');
                            $this->db->where_not_in('status', $status);
                            $cartQuery = $this->db->get('cart');

                            ?>

                            <li class="parent-menu cart">
                                <a title="Total Cart" href="<?php echo base_url();?>home/shop/cart/" ><i class="fa fa-shopping-bag"></i> (<?php echo $cartQuery->num_rows(); ?>)</a>
                            </li>

                            <?php if( $this->session->userdata('logged_in') == false ){ ?>
                                <li class="parent-menu">
                                    <a href="<?php echo base_url();?>login/" ><i class="fa fa-lock"></i> Login</a>
                                </li>
                            <?php }else{ ?>
                                <li class="parent-menu">
                                    <a href="<?php echo base_url();?>dashboard/" ><i class="fa fa-cog"></i> Dashboard</a>
                                </li>
                            <?php } ?>

                          </ul>
                        </div>
                    </nav>
                </div>
                </div>
            </div>
        </div>
<?php endforeach;?>


        <?php
            $success = $this->session->flashdata('success');
            $notsuccess = $this->session->flashdata('notsuccess');

            if ($success) {
                ?>

                <div class="success_notifi notifi" id="success_notifi" style="display:block;">
                    <p><i class="fa fa-check"></i> <?php echo $success; ?></p>
                </div>

            <?php } elseif ($notsuccess) { ?>

                <div class="warning_notifi notifi" id="warning_notifi" style="display:block;">
                    <p><i class="fa fa-times"></i> <?php echo $notsuccess; ?></p>
                </div>

            <?php } ?>
