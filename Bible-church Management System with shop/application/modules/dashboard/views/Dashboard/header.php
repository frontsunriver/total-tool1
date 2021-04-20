<?php
$cmodule = $this->uri->segment(1); //Church Module
$ccontroller = $this->uri->segment(2); //Church Controller
$cmethod = $this->uri->segment(3); //Church Method

if (!$ccontroller && $cmodule == "dashboard") {
    $itdash = "dashboard";
} else {
    $itdash = "notdashboard";
}

$user_position = $this->session->userdata('user_position');
$siteinfo = $this->db->get('websitebasic');
$siteinfo = $siteinfo->result();
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/assets/images/website/<?php echo $siteinfo[0]->favicon; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title><?php echo $siteinfo[0]->title; ?> | <?php echo $siteinfo[0]->tag; ?></title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="<?php echo base_url(); ?>assets/css/material-dashboard.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/assets/css/custom_style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/assets/css/nice-select.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/assets/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/assets/checkbox/style.css" rel="stylesheet" />

    <!--  Cropper CDN CSS     -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropper/3.1.3/cropper.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

    <!-- Include Trumbowyg Editor style -->
    <link href="<?php echo base_url(); ?>assets/assets/trumbowyg/dist/ui/trumbowyg.min.css" rel="stylesheet" type="text/css" />

    <!-- Include Data Table style -->
    <link href="<?php echo base_url(); ?>assets/assets/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/assets/datatables/css/buttons.bootstrap4.min.css" rel="stylesheet" />

    <link href="<?php echo base_url(); ?>assets/assets/fullcalendar/fullcalendar.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/assets/fullcalendar/fullcalendar.print.min.css" rel="stylesheet" media="print">

    <!-- Main JS Loading Here -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>

    <!-- Add FullCalendar -->
    <script src="<?php echo base_url(); ?>assets/assets/fullcalendar/lib/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets/fullcalendar/fullcalendar.min.js"></script>

    <style>
        /*OWL Slider*/
        body.dragging,
        body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            opacity: 0.5;
            z-index: 2000;
        }

        ol.example li.placeholder {
            position: relative;
            /** More li styles **/
        }

        ol.example li.placeholder:before {
            position: absolute;
            /** Define arrowhead **/
        }

        /* Theme Color Change*/
        <?php $themeColor = $siteinfo[0]->color; ?>a {
            color: <?php echo $themeColor; ?>;
        }

        .gIconColor {
            background: <?php echo $themeColor; ?> !important;
            box-shadow: none !important;
            border-radius: 100% !important;
            padding: 0px !important;
            margin: -20px 0 0 20px !important;
            border: 2px solid rgba(51, 51, 89, 0.41);
        }

        .sidebar .nav i,
        .off-canvas-sidebar .nav i {
            color: <?php echo $themeColor; ?>;
        }

        .card [data-background-color="purple"] {
            background: <?php echo $themeColor; ?>;
            box-shadow: none;
        }

        .image_select_text {
            background: <?php echo $themeColor; ?>;
        }

        .file_import_btn {
            background: <?php echo $themeColor; ?>;
        }

        .imageWrapper {
            border: 1px solid <?php echo $themeColor; ?> !important;
        }

        img#image {
            border: 1px solid <?php echo $themeColor; ?> !important;
        }

        .form-control,
        .form-group .form-control {
            border: 0;
            background-image: linear-gradient(<?php echo $themeColor; ?>, <?php echo $themeColor; ?>), linear-gradient(#D2D2D2, #D2D2D2) !important;
        }

        .website img.favicon,
        .website img.logo {
            border: 1px solid <?php echo $themeColor; ?>;
        }

        .fr-toolbar {
            border-top: 1px solid <?php echo $themeColor; ?> !important;
        }

        .fr-toolbar.fr-top {
            box-shadow: 0 0px 1px <?php echo $themeColor; ?>, 0 0px 1px 0px <?php echo $themeColor; ?> !important;
        }

        .fr-box.fr-basic.fr-top .fr-wrapper {
            box-shadow: 0 0px 1px <?php echo $themeColor; ?>, 0 0px 1px 0px <?php echo $themeColor; ?> !important;
        }

        .btn.btn-primary,
        .btn.btn-primary:hover,
        .btn.btn-primary:focus,
        .btn.btn-primary:active,
        .btn.btn-primary.active,
        .btn.btn-primary:active:focus,
        .btn.btn-primary:active:hover,
        .btn.btn-primary.active:focus,
        .btn.btn-primary.active:hover,
        .open>.btn.btn-primary.dropdown-toggle,
        .open>.btn.btn-primary.dropdown-toggle:focus,
        .open>.btn.btn-primary.dropdown-toggle:hover,
        .navbar .navbar-nav>li>a.btn.btn-primary,
        .navbar .navbar-nav>li>a.btn.btn-primary:hover,
        .navbar .navbar-nav>li>a.btn.btn-primary:focus,
        .navbar .navbar-nav>li>a.btn.btn-primary:active,
        .navbar .navbar-nav>li>a.btn.btn-primary.active,
        .navbar .navbar-nav>li>a.btn.btn-primary:active:focus,
        .navbar .navbar-nav>li>a.btn.btn-primary:active:hover,
        .navbar .navbar-nav>li>a.btn.btn-primary.active:focus,
        .navbar .navbar-nav>li>a.btn.btn-primary.active:hover,
        .open>.navbar .navbar-nav>li>a.btn.btn-primary.dropdown-toggle,
        .open>.navbar .navbar-nav>li>a.btn.btn-primary.dropdown-toggle:focus,
        .open>.navbar .navbar-nav>li>a.btn.btn-primary.dropdown-toggle:hover {
            background-color: <?php echo $themeColor; ?> !important;
            color: #FFFFFF;
            box-shadow: none;
        }

        .sidebar[data-color="purple"] .nav li.active a,
        .off-canvas-sidebar[data-color="purple"] .nav li.active a {
            background: linear-gradient(60deg, <?php echo $themeColor; ?>, <?php echo $themeColor; ?>);
            box-shadow: none;
        }

        ul.active.nav_child li.active {
            background: <?php echo $themeColor; ?> !important;
        }

        .sidebar .nav li ul {
            border-right: 3px solid <?php echo $themeColor; ?>;
        }

        .view_mainsite,
        .view_mainsite:hover {
            background: <?php echo $themeColor; ?> !important;
            box-shadow: none;
        }

        .navbar .notification {
            border: 0px !important;
            background: <?php echo $themeColor; ?> !important;
        }

        .success_notifi {
            background: <?php echo $themeColor; ?>;
        }

        .navbar .dropdown-menu li a:hover,
        .navbar .dropdown-menu li a:focus,
        .navbar .dropdown-menu li a:active,
        .navbar.navbar-default .dropdown-menu li a:hover,
        .navbar.navbar-default .dropdown-menu li a:focus,
        .navbar.navbar-default .dropdown-menu li a:active {
            background-color: <?php echo $themeColor; ?> !important;
            color: #FFFFFF;
            box-shadow: none;
        }

        .datepicker table tr td.active.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled.disabled,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active.disabled:hover.active,
        .datepicker table tr td.active.disabled:hover.disabled,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.disabled:hover:hover,
        .datepicker table tr td.active.disabled:hover[disabled],
        .datepicker table tr td.active.disabled[disabled],
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active:hover.disabled,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active:hover:hover,
        .datepicker table tr td.active:hover[disabled],
        .datepicker table tr td.active[disabled] {
            background-color: <?php echo $themeColor; ?> !important;
        }

        .datepicker table tr td.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active:hover {
            background-image: linear-gradient(to bottom, <?php echo $themeColor; ?>, <?php echo $themeColor; ?>) !important;
        }

        .nice-select.open .list {
            border: 3px solid <?php echo $themeColor; ?> !important;
        }

        .nice-select .option:hover,
        .nice-select .option.focus,
        .nice-select .option.selected.focus {
            background-color: <?php echo $themeColor; ?>;
        }

        .pagination>.active>a,
        .pagination>.active>a:focus,
        .pagination>.active>a:hover,
        .pagination>.active>span,
        .pagination>.active>span:focus,
        .pagination>.active>span:hover {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: <?php echo $themeColor; ?>;
            border-color: <?php echo $themeColor; ?>;
        }

        .pagination li a,
        .pagination li span {
            position: relative;
            float: left;
            padding: 12px 20px !important;
            margin-left: -1px;
            line-height: 1.42857143;
            color: <?php echo $themeColor; ?>;
            text-decoration: none;
            background-color: #ffffff;
            border: 1px solid <?php echo $themeColor; ?>;
        }

        .pagination>li>a:focus,
        .pagination>li>a:hover,
        .pagination>li>span:focus,
        .pagination>li>span:hover {
            z-index: 3;
            color: #ffffff;
            background-color: <?php echo $themeColor; ?>;
            border-color: <?php echo $themeColor; ?>;
        }

        .demoNotification {
            margin: 100px auto 0;
            float: none;
            width: 92%;
            font-size: 5px;
            color: #ff0000;
            font-weight: bold;
            background: #FFEB3B;
            display: block;
            padding: 2px 0;
            text-transform: uppercase;
            border-radius: 5px;
        }


        ul.nav.basic_settings.nav-tabs {
            background-color: <?php echo $themeColor; ?>;
        }

        .trumbowyg-editor {
            border: 1px solid <?php echo $themeColor; ?>;
        }

        .trumbowyg-box svg {
            width: 20px;
            fill: #fff;
        }

        .trumbowyg-box {
            border: 0px solid #DDD;
        }

        .trumbowyg-button-pane {
            background: <?php echo $themeColor; ?>;
            border-bottom: 1px solid <?php echo $themeColor; ?>;
        }

        .trumbowyg-button-pane::after {
            background: <?php echo $themeColor; ?>;
        }

        .trumbowyg-button-pane .trumbowyg-button-group:not(:empty)+.trumbowyg-button-group::before {
            content: " ";
            display: inline-block;
            width: 0px;
            background: #ffffff;
            margin: 0;
            height: 35px;
        }

        .trumbowyg-box svg {
            width: 20px;
        }

        .trumbowyg-button-pane button.trumbowyg-active,
        .trumbowyg-button-pane button:not(.trumbowyg-disable):focus,
        .trumbowyg-button-pane button:not(.trumbowyg-disable):hover {
            background-color: rgba(255, 255, 255, 0);
            outline: 0;
        }

        .trumbowyg-box svg:hover {
            width: 17px;
            height: 100%;
            fill: #fff;
        }

        svg#trumbowyg-view-html,
        svg#trumbowyg-view-html path {
            color: #fff;
        }
    </style>

</head>

<body>

    <div class="wrapper">
        <div class="loading" id="loading" style="display:none;">
            <img src="<?php echo base_url(); ?>assets/assets/images/loading.svg" alt="Loading">
        </div>

        <div class="warning_notifi notifi" id="warning_notifi" style="display:none;">
            <p><i class="material-icons">error</i> Oops! Something Wrong</p>
        </div>

        <div class="success_notifi notifi" id="success_notifi" style="display:none;">
            <p><i class="material-icons">check_box</i> Successfully Updated</p>
        </div>

        <?php
        $success = $this->session->flashdata('success');
        $notsuccess = $this->session->flashdata('notsuccess');

        if ($success) {
        ?>

            <div class="success_notifi notifi" id="success_notifi" style="display:block;">
                <p><i class="material-icons">check_box</i> <?php echo $success; ?></p>
            </div>

        <?php } elseif ($notsuccess) { ?>

            <div class="warning_notifi notifi" id="warning_notifi" style="display:block;">
                <p><i class="material-icons">error</i> <?php echo $notsuccess; ?></p>
            </div>

        <?php } ?>


        <div class="sidebar" data-color="purple">

            <div class="logo text-center">
                <a href="<?php echo base_url(); ?>">
                    <img src="<?php echo base_url(); ?>assets/assets/images/website/<?php echo $siteinfo[0]->logo; ?>" alt="Logo">
                </a>
            </div>

            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="<?php
                                if ($itdash == "dashboard") {
                                    echo "active";
                                }
                                ?>">
                        <a href="<?php echo base_url('dashboard'); ?>">
                            <i class="material-icons">dashboard</i>
                            <p><?php echo $this->lang->line('dash_menu_dash'); ?></p>
                        </a>
                    </li>

                    <?php if ($user_position) { ?>

                        <?php if (isset(chkpms()->website) && chkpms()->website == "on") { ?>
                            <li class="<?php if ($ccontroller == "website" || $ccontroller == "page" || $ccontroller == "menu" || $ccontroller == "section") {
                                            echo "active";
                                        } ?> nav_parent">
                                <a> <i class="material-icons">format_align_center</i>
                                    <p><?php echo $this->lang->line('dash_menu_website'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>


                                <ul class="<?php
                                            if ($ccontroller == "website" || $ccontroller == "page" || $ccontroller == "section" || $ccontroller == "menu") {
                                                echo "active";
                                            }
                                            ?> nav_child">

                                    <li class="<?php
                                                if ($cmethod == "header") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/website/header'); ?>">
                                            <i class="material-icons">format_align_center</i>
                                            <p><?php echo $this->lang->line('dash_menu_basic'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($ccontroller == "menu") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/menu'); ?>">
                                            <i class="material-icons">format_align_center</i>
                                            <p><?php echo $this->lang->line('dash_menu_menus'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "slider") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/website/slider'); ?>">
                                            <i class="material-icons">format_align_center</i>
                                            <p><?php echo $this->lang->line('dash_menu_slider'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "gallery") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/website/gallery'); ?>">
                                            <i class="material-icons">format_align_center</i>
                                            <p><?php echo $this->lang->line('dash_menu_gallery'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($ccontroller == "section") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/section'); ?>">
                                            <i class="material-icons">format_align_center</i>
                                            <p><?php echo $this->lang->line('dash_menu_section'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($ccontroller == "page") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/page'); ?>">
                                            <i class="material-icons">format_align_center</i>
                                            <p><?php echo $this->lang->line('dash_menu_page'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->finance) && chkpms()->finance == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "financial") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">attach_money</i>
                                    <p><?php echo $this->lang->line('dash_menu_financial'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "financial") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "funds") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/financial/funds'); ?>">
                                            <i class="material-icons">attach_money</i>
                                            <p><?php echo $this->lang->line('dash_menu_finfunds'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "donation") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/financial/donation'); ?>">
                                            <i class="material-icons">attach_money</i>
                                            <p><?php echo $this->lang->line('dash_menu_findonations'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "assets") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/financial/assets'); ?>">
                                            <i class="material-icons">widgets</i>
                                            <p><?php echo $this->lang->line('dash_menu_fincassets'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->sermon) && chkpms()->sermon == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "sermon") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">record_voice_over</i>
                                    <p><?php echo $this->lang->line('dash_menu_sermons'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "sermon") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addsermon") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/sermon/addsermon'); ?>">
                                            <i class="material-icons">record_voice_over</i>
                                            <p><?php echo $this->lang->line('dash_menu_addsermon'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allsermons") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/sermon/allsermons'); ?>">
                                            <i class="material-icons">record_voice_over</i>
                                            <p><?php echo $this->lang->line('dash_menu_allsermons'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->event) && chkpms()->event == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "event") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">notifications_active</i>
                                    <p><?php echo $this->lang->line('dash_menu_events'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "event") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addevent") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/event/addevent'); ?>">
                                            <i class="material-icons">notifications_active</i>
                                            <p><?php echo $this->lang->line('dash_menu_addevent'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allevents") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/event/allevents'); ?>">
                                            <i class="material-icons">notifications_active</i>
                                            <p><?php echo $this->lang->line('dash_menu_allevents'); ?></p>
                                        </a>
                                    </li>
                                    <li class="<?php
                                                if ($cmethod == "registered") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/event/addapplicant'); ?>">
                                            <i class="material-icons">notifications_active</i>
                                            <p><?php echo $this->lang->line('dash_menu_addapplicant'); ?></p>
                                        </a>
                                    </li>
                                    <li class="<?php
                                                if ($cmethod == "registered") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/event/applicants'); ?>">
                                            <i class="material-icons">notifications_active</i>
                                            <p><?php echo $this->lang->line('dash_menu_allapplicants'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>


                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->prayer) && chkpms()->prayer == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "prayer") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">bookmark</i>
                                    <p><?php echo $this->lang->line('dash_menu_prayer'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "prayer") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addprayer") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/prayer/addprayer'); ?>">
                                            <i class="material-icons">bookmark</i>
                                            <p><?php echo $this->lang->line('dash_menu_addprayer'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allprayers") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/prayer/allprayers'); ?>">
                                            <i class="material-icons">bookmark</i>
                                            <p><?php echo $this->lang->line('dash_menu_allprayers'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->notice) && chkpms()->notice == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "notice") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">bookmark</i>
                                    <p><?php echo $this->lang->line('dash_menu_notice'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "notice") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addnotice") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/notice/addnotice'); ?>">
                                            <i class="material-icons">bookmark</i>
                                            <p><?php echo $this->lang->line('dash_menu_addnotice'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allnotices") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/notice/allnotices'); ?>">
                                            <i class="material-icons">bookmark</i>
                                            <p><?php echo $this->lang->line('dash_menu_allnotices'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->speech) && chkpms()->speech == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "speech") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">forum</i>
                                    <p><?php echo $this->lang->line('dash_menu_speech'); ?> <i class="right material-icons ">add_circle</i> </p>

                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "speech") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addspeech") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/speech/addspeech'); ?>">
                                            <i class="material-icons">forum</i>
                                            <p><?php echo $this->lang->line('dash_menu_addspeech'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allspeech") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/speech/allspeech'); ?>">
                                            <i class="material-icons">forum</i>
                                            <p><?php echo $this->lang->line('dash_menu_allspeech'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->family) && chkpms()->family == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "family") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">group</i>
                                    <p><?php echo $this->lang->line('dash_menu_families'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "family") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addfamily") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/family/addfamily'); ?>">
                                            <i class="material-icons">person</i>
                                            <p><?php echo $this->lang->line('dash_menu_addfamily'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allfamily") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/family/allfamily'); ?>">
                                            <i class="material-icons">people</i>
                                            <p><?php echo $this->lang->line('dash_menu_allfamilies'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>



                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->department) && chkpms()->department == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "department") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">view_module</i>
                                    <p><?php echo $this->lang->line('dash_menu_department'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "department") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "adddepartment") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/department/adddepartment'); ?>">
                                            <i class="material-icons">view_module</i>
                                            <p><?php echo $this->lang->line('dash_menu_adddepartment'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "alldepartment") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/department/alldepartment'); ?>">
                                            <i class="material-icons">view_module</i>
                                            <p><?php echo $this->lang->line('dash_menu_alldepartment'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>


                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->committee) && chkpms()->committee == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "committee") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">group</i>
                                    <p><?php echo $this->lang->line('dash_menu_committee'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "committee") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addcommittee") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/committee/addcommittee'); ?>">
                                            <i class="material-icons">group</i>
                                            <p><?php echo $this->lang->line('dash_menu_addcommittee'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allcommittee") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/committee/allcommittee'); ?>">
                                            <i class="material-icons">group</i>
                                            <p><?php echo $this->lang->line('dash_menu_allcommittee'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>



                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->member) && chkpms()->member == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "member") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">group</i>
                                    <p><?php echo $this->lang->line('dash_menu_members'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "member") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addmember") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/member/addmember'); ?>">
                                            <i class="material-icons">person</i>
                                            <p><?php echo $this->lang->line('dash_menu_addmembers'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allmembers") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/member/allmembers'); ?>">
                                            <i class="material-icons">people</i>
                                            <p><?php echo $this->lang->line('dash_menu_allmembers'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->pastor) && chkpms()->pastor == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "pastor") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">group</i>
                                    <p><?php echo $this->lang->line('dash_menu_pastors'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "pastor") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addpastor") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/pastor/addpastor'); ?>">
                                            <i class="material-icons">person</i>
                                            <p><?php echo $this->lang->line('dash_menu_addpastors'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allpastors") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/pastor/allpastors'); ?>">
                                            <i class="material-icons">people</i>
                                            <p><?php echo $this->lang->line('dash_menu_allpastors'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->clans) && chkpms()->clans == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "clan") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">group</i>
                                    <p><?php echo $this->lang->line('dash_menu_clans'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "clan") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addclan") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/clan/addclan'); ?>">
                                            <i class="material-icons">person_add</i>
                                            <p><?php echo $this->lang->line('dash_menu_addclan'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allclans") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/clan/allclans'); ?>">
                                            <i class="material-icons">group</i>
                                            <p><?php echo $this->lang->line('dash_menu_allclans'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->chorus) && chkpms()->chorus == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "chorus") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">group</i>
                                    <p><?php echo $this->lang->line('dash_menu_chorus'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "chorus") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addchorus") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/chorus/addchorus'); ?>">
                                            <i class="material-icons">person_add</i>
                                            <p><?php echo $this->lang->line('dash_menu_addchorus'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allchorus") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/chorus/allchorus'); ?>">
                                            <i class="material-icons">group</i>
                                            <p><?php echo $this->lang->line('dash_menu_allchorus'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->staffs) && chkpms()->staffs == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "staff") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">group</i>
                                    <p><?php echo $this->lang->line('dash_menu_churchstaffs'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "staff") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addstaff") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/staff/addstaff'); ?>">
                                            <i class="material-icons">person_add</i>
                                            <p><?php echo $this->lang->line('dash_menu_addchurchstaff'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allstaffs") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/staff/allstaffs'); ?>">
                                            <i class="material-icons">group</i>
                                            <p><?php echo $this->lang->line('dash_menu_allchurchstaffs'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->school) && chkpms()->school == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "school") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">games</i>
                                    <p><?php echo $this->lang->line('dash_menu_sundayschool'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "school") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addstudent") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/school/addstudent'); ?>">
                                            <i class="material-icons">person_add</i>
                                            <p><?php echo $this->lang->line('dash_menu_addstudent'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allstudents") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/school/allstudents'); ?>">
                                            <i class="material-icons">group</i>
                                            <p><?php echo $this->lang->line('dash_menu_allstudents'); ?></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->user) && chkpms()->user == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "user") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">people</i>
                                    <p><?php echo $this->lang->line('dash_menu_users'); ?> <i class="right material-icons ">add_circle</i> </p>

                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "user") {
                                                echo "active";
                                            }
                                            ?> nav_child">

                                    <li class="<?php
                                                if ($cmethod == "adduser") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/user/adduser'); ?>">
                                            <i class="material-icons">person_add</i>
                                            <p><?php echo $this->lang->line('dash_menu_adduser'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allusers") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/user/allusers'); ?>">
                                            <i class="material-icons">people</i>
                                            <p><?php echo $this->lang->line('dash_menu_allusers'); ?></p>
                                        </a>
                                    </li>
                                    <li class="<?php
                                                if ($cmethod == "roles") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/user/roles'); ?>">
                                            <i class="material-icons">people</i>
                                            <p><?php echo $this->lang->line('dash_menu_roles'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->seminar) && chkpms()->seminar == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "seminar") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">flare</i>
                                    <p><?php echo $this->lang->line('dash_menu_seminars'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "seminar") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addseminar") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/seminar/addseminar'); ?>">
                                            <i class="material-icons">flare</i>
                                            <p><?php echo $this->lang->line('dash_menu_addseminar'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allseminar") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/seminar/allseminar'); ?>">
                                            <i class="material-icons">flare</i>
                                            <p><?php echo $this->lang->line('dash_menu_allseminars'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allregistered") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/seminar/applicants'); ?>">
                                            <i class="material-icons">flare</i>
                                            <p><?php echo $this->lang->line('dash_menu_allapplicants'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>


                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->attendance) && chkpms()->attendance == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "attendance") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">assignment_turned_in</i>
                                    <p><?php echo $this->lang->line('dash_menu_attendance'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "attendance") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "attendancetype") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/attendance/addtype'); ?>">
                                            <i class="material-icons">assignment_turned_in</i>
                                            <p><?php echo $this->lang->line('dash_menu_attendancetype'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "attendance") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/attendance'); ?>">
                                            <i class="material-icons">assignment_turned_in</i>
                                            <p><?php echo $this->lang->line('dash_menu_attendancebrowse'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>

                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->communicaction) && chkpms()->communicaction == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "communication") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">sms</i>
                                    <p><?php echo $this->lang->line('dash_menu_communication'); ?> <i class="right material-icons ">add_circle</i> </p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "communication") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "sms") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/communication/sms'); ?>">
                                            <i class="material-icons">sms</i>
                                            <p><?php echo $this->lang->line('dash_menu_sms'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "email") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/communication/email'); ?>">
                                            <i class="material-icons">email</i>
                                            <p><?php echo $this->lang->line('dash_menu_email'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>


                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->blog) && chkpms()->blog == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "blog") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">speaker_notes</i>
                                    <p><?php echo $this->lang->line('dash_menu_blog'); ?> <i class="right material-icons ">add_circle</i></p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "blog") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addpost") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/blog/addpost'); ?>">
                                            <i class="material-icons">speaker_notes</i>
                                            <p><?php echo $this->lang->line('dash_menu_addblog'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allposts") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/blog/allposts'); ?>">
                                            <i class="material-icons">speaker_notes</i>
                                            <p><?php echo $this->lang->line('dash_menu_allblog'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>


                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->shop) && chkpms()->shop == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "shop") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">shop</i>
                                    <p><?php echo $this->lang->line('dash_menu_shop'); ?> <i class="right material-icons ">add_circle</i></p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "shop") {
                                                echo "active";
                                            }
                                            ?> nav_child">

                                    <?php $userID = $this->session->user_id;
                                    $userPosition = $this->session->user_position;
                                    if ($userPosition !== 'Contributor' && $userPosition !== 'Subscriber') { ?>
                                        <li class="<?php
                                                    if ($cmethod == "addproduct") {
                                                        echo "active";
                                                    }
                                                    ?>">
                                            <a href="<?php echo base_url('dashboard/shop/addproduct'); ?>">
                                                <i class="material-icons">speaker_notes</i>
                                                <p><?php echo $this->lang->line('dash_menu_addproduct'); ?></p>
                                            </a>
                                        </li>


                                        <li class="<?php
                                                    if ($cmethod == "allproducts") {
                                                        echo "active";
                                                    }
                                                    ?>">
                                            <a href="<?php echo base_url('dashboard/shop/allproducts'); ?>">
                                                <i class="material-icons">speaker_notes</i>
                                                <p><?php echo $this->lang->line('dash_menu_allproducts'); ?></p>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <li class="<?php
                                                if ($cmethod == "orders") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/shop/allorders'); ?>">
                                            <i class="material-icons">speaker_notes</i>
                                            <p><?php echo $this->lang->line('dash_menu_allorders'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                    <?php }
                    } ?>


                    <?php if ($user_position) { ?>
                        <?php if (isset(chkpms()->import) && chkpms()->import == "on") { ?>
                            <li class="<?php
                                        if ($ccontroller == "import") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a href="<?php echo base_url('dashboard/import'); ?>">
                                    <i class="material-icons">subdirectory_arrow_left</i>
                                    <p><?php echo $this->lang->line('dash_menu_import'); ?> </p>
                                </a>
                            </li>
                    <?php }
                    } ?>


                    <!-- Users Menus -->


                    <!-- <?php if ($user_position) { ?>
                            <li class="<?php
                                        if ($ccontroller == "blog") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">speaker_notes</i>
                                    <p><?php echo $this->lang->line('dash_menu_blog'); ?> <i class="right material-icons ">add_circle</i></p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "blog") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "addpost") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/userpanel/blog/addpost'); ?>">
                                            <i class="material-icons">speaker_notes</i>
                                            <p><?php echo $this->lang->line('dash_menu_addblog'); ?></p>
                                        </a>
                                    </li>

                                    <li class="<?php
                                                if ($cmethod == "allposts") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/userpanel/blog/allposts'); ?>">
                                            <i class="material-icons">speaker_notes</i>
                                            <p><?php echo $this->lang->line('dash_menu_allblog'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php } ?>



                        <?php if ($user_position) { ?>
                            <li class="<?php
                                        if ($ccontroller == "shop") {
                                            echo "active";
                                        }
                                        ?> nav_parent">
                                <a>
                                    <i class="material-icons">shop</i>
                                    <p><?php echo $this->lang->line('dash_menu_shop'); ?> <i class="right material-icons ">add_circle</i></p>
                                </a>

                                <ul class="<?php
                                            if ($ccontroller == "shop") {
                                                echo "active";
                                            }
                                            ?> nav_child">
                                    <li class="<?php
                                                if ($cmethod == "orders") {
                                                    echo "active";
                                                }
                                                ?>">
                                        <a href="<?php echo base_url('dashboard/userpanel/shop/allorders'); ?>">
                                            <i class="material-icons">speaker_notes</i>
                                            <p><?php echo $this->lang->line('dash_menu_allorders'); ?></p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php } ?> -->

                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand view_mainsite closeSidebar" href="#"><i class="material-icons">subdirectory_arrow_left</i></a>
                        <a class="navbar-brand" href="#"><?php echo $siteinfo[0]->title; ?> | <?php echo $siteinfo[0]->tag; ?> </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?php echo base_url(); ?>" target="_blank">
                                    <i class="material-icons">format_align_center</i>
                                    <?php echo $this->lang->line('dash_view_front'); ?></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i>
                                    <span class="notification">3</span>
                                    <p class="hidden-lg hidden-md">Profile</p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url(); ?>dashboard/setting/profile"><i class="material-icons">person</i> View Profile</a></li>
                                    <li><a href="<?php echo base_url(); ?>dashboard/setting/editprofile"><i class="material-icons">person</i> Update Profile</a></li>
                                    <li><a href="<?php echo base_url(); ?>access/login/logout/"><i class="material-icons">power_settings_new</i> Logout</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">translate</i>
                                    <span class="notification">10</span>
                                    <p class="hidden-lg hidden-md">Language</p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/english'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/english.png" alt="english"> <?php echo $this->lang->line('dash_lenglish'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/bengali'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/bengali.png" alt="bengali"> <?php echo $this->lang->line('dash_lbengali'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/hindi'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/hindi.png" alt="hindi"> <?php echo $this->lang->line('dash_lhindi'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/spanish'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/spanish.png" alt="spanish"> <?php echo $this->lang->line('dash_lspanish'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/portuguese'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/portuguese.png" alt="portuguese"> <?php echo $this->lang->line('dash_lportuguese'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/french'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/french.png" alt="french"> <?php echo $this->lang->line('dash_lfrench'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/dutch'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/dutch.png" alt="dutch"> <?php echo $this->lang->line('dash_ldutch'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/german'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/german.png" alt="german"> <?php echo $this->lang->line('dash_lgerman'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/italian'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/italian.png" alt="italian"> <?php echo $this->lang->line('dash_litalian'); ?></a></li>
                                    <li><a href='<?php echo base_url(); ?>dashboard/switchLang/swedish'><img class="lang_img" src="<?php echo base_url(); ?>assets/assets/images/language/swedish.png" alt="swedish"> <?php echo $this->lang->line('dash_lswedish'); ?></a></li>
                                </ul>
                            </li>
                            <?php if ((isset($user_position) && !empty($user_position)) && ($user_position == "Superadmin" || $user_position == "Admin")) { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="material-icons">settings_applications</i>
                                        <span class="notification">2</span>
                                        <p class="hidden-lg hidden-md">Settings</p>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href='<?php echo base_url(); ?>dashboard/website/header'><i class="material-icons">settings</i> <?php echo $this->lang->line('dash_menu_basic'); ?></a></li>
                                        <li><a href='<?php echo base_url(); ?>dashboard/website/updateDatabase'><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_menu_dbupdate'); ?></a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php if ($this->uri->segment(1) == "dashboard" && $this->uri->segment(2) == "") { ?>
                <div class="validPurchase marginTop100">
                    <?php if (!$purchase) { ?>
                        <div class="text-center">
                            <h3 style="color:#f44336">Please Verify Your Purchase Code. <b>(Limited Edition)</b></h3>
                            <a href="https://codecanyon.net/item/bible-church-management-system/20615578" target="_blank"><i class="material-icons">link</i> Buy Now</a>
                        </div>

                        <form id="validPurchaseForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/dashboard/verifyPurchase" method="post" enctype="multipart/form-data">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="form-group label-floating">
                                    <input name="purchasecode" type="text" class="form-control" placeholder="Insert Purchase Code Here" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group label-floating">
                                    <button id="validPurchaseSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> Verify Now</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>

                </div>
            <?php } ?>