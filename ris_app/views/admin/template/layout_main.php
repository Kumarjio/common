<?php $session = $this->session->userdata('admin_session'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <title><?php echo @$page_title . ' | ' . $this->config->item('app_name'); ?></title>

        <link href="<?php echo PLUGIN_URL; ?>summernote/summernote.min.css" rel="stylesheet">
        <link href="<?php echo PLUGIN_URL; ?>sweet-alert/sweet-alert.css" rel="stylesheet">
        <link href="<?php echo PLUGIN_URL; ?>datatables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo PLUGIN_URL; ?>datepicker/datepicker.min.css" rel="stylesheet">

        <link href="<?php echo ADMIN_CSS_URL; ?>bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo ADMIN_CSS_URL; ?>ionicons.min.css" rel="stylesheet" />
        <link href="<?php echo ADMIN_CSS_URL; ?>style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ADMIN_CSS_URL; ?>custom.css" rel="stylesheet">

        <link href="<?php echo ADMIN_CSS_URL; ?>font-awesome.css" rel="stylesheet" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo ADMIN_JS_URL; ?>jquery.min.js"></script>
        <script src="<?php echo ADMIN_JS_URL; ?>jquery-ui-1.10.3.min.js"></script>
        <script src="<?php echo ADMIN_JS_URL; ?>jquery.validate.js"></script>
        
        <script src="<?php echo PLUGIN_URL; ?>datatables/jquery.dataTables.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>datatables/dataTables.bootstrap.js"></script>

        <link href="<?php echo PLUGIN_URL; ?>icheck/skins/all.css" rel="stylesheet">

        <script type="text/javascript">
            var http_host_js = '<?php echo ADMIN_URL; ?>';
        </script>
    </head>

    <body class="tooltips skin-blue">

        <header class="header">
            <a href="<?php echo ADMIN_URL; ?>" class="logo">
                <?php echo $this->config->item('app_name'); ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $session->name; ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <p><?php echo $session->name; ?>
                                    <small><?php echo $session->email; ?></small></p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        &nbsp;
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo ADMIN_URL. 'logout'; ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <?php
                $uri_1 = ($this->uri->segment(2) ? $this->uri->segment(2) : 'dashboard');
                $uri_2 = ($this->uri->segment(2) ? $this->uri->segment(3) ? $this->uri->segment(3) : $this->uri->segment(2) : 'dashboard');  
                ?>
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="<?php echo ($uri_2 == 'dashboard') ? 'active' : ''; ?>"><a href="<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a> </li>

                        <li class="<?php echo ($uri_2 == 'company') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'company'; ?>"><i class="fa fa-users"></i>Company</a></li>

                        <li class="<?php echo ($uri_2 == 'newsletter') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'newsletter'; ?>"><i class="fa fa-newspaper-o"></i>Campaign</a></li>

                        <li class="treeview <?php echo ($uri_2 == 'businesscategory' || $uri_2 == 'businesssubcategory') ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Business</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                 <li class="<?php echo ($uri_2 == 'businesscategory') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'businesscategory'; ?>"><i class="fa fa-cog"></i>Category</a></li>

                                <li class="<?php echo ($uri_2 == 'businesssubcategory') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'businesssubcategory'; ?>"><i class="fa fa-cog"></i>Sub Category</a></li>
                            </ul>
                        </li>

                        <li class="treeview <?php echo ($uri_2 == 'businesscategory' || $uri_2 == 'businesssubcategory') ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Tranning Center</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                 <li class="<?php echo ($uri_2 == 'batch') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'batch'; ?>"><i class="fa fa-cog"></i>Batch</a></li>

                                <li class="<?php echo ($uri_2 == 'student') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'student'; ?>"><i class="fa fa-cog"></i>Student</a></li>

                                <li class="<?php echo ($uri_2 == 'student') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'student/fee'; ?>"><i class="fa fa-cog"></i>Student Fee</a></li>
                            </ul>
                        </li>

                    
                        <li class="treeview <?php echo ($uri_2 == 'page' || $uri_2 == 'email' || $uri_2 == 'newslettertemplate') ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Templates</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($uri_2 == 'page') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'page'; ?>"><i class="fa fa-file-text"></i>Page</a></li>

                                <li class="<?php echo ($uri_2 == 'email') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'email'; ?>"><i class="fa fa-envelope"></i>Email</a></li>

                                <li class="<?php echo ($uri_2 == 'newslettertemplate') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'newslettertemplate'; ?>"><i class="fa fa-envelope"></i>Newsletter</a></li>
                            </ul>
                        </li>

                        <li class="treeview <?php echo ($uri_1 == 'system_setting' && ($uri_2 == 'general' || $uri_2 == 'mail')) ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Settings</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($uri_2 == 'general') ? 'active' : ''; ?>"><a href="<?php echo ADMIN_URL .'system_setting/general'; ?>"><i class="fa fa-wrench"></i> General Setting</a></li>
                                <li class="<?php echo ($uri_2 == 'mail') ? 'active' : ''; ?>"><a href="<?php echo ADMIN_URL .'system_setting/mail'; ?>"><i class="fa fa-wrench"></i> Mail Setting</a></li>
                            </ul>
                        </li>

                        <li class="<?php echo ($uri_1 == 'system_setting' && $uri_2 == 'login_credential') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'system_setting/login_credential'; ?>"><i class="fa fa-gears"></i>Edit Profile</a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <aside class="right-side">
                <?php if(!empty($page_h1_title)){ ?>
                    <section class="content-header">
                        <h1><?php echo @$page_h1_title; ?></h1>
                    </section>
                <?php } ?>

                <?php if ($this->session->flashdata('success') != '') { ?>
                    <div class="pad margin no-print">
                        <div class="auto-close alert alert-success fade in alert-dismissable">
                            <i class="fa fa-thumbs-o-up"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="text-center">
                                <?php echo $this->session->flashdata('success'); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->flashdata('warning') != '') { ?>
                    <div class="pad margin no-print">
                        <div class="auto-close alert alert-warning fade in alert-dismissable">
                            <i class="fa fa-warning"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="text-center">
                                <?php echo $this->session->flashdata('warning'); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->flashdata('info') != '') { ?>
                    <div class="pad margin no-print">
                        <div class="auto-close alert alert-info fade in alert-dismissable">
                            <i class="fa fa-info"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="text-center">
                                <?php echo $this->session->flashdata('info'); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->flashdata('error') != '') { ?>
                    <div class="pad margin no-print">
                        <div class="auto-close alert alert-danger fade in alert-dismissable">
                            <i class="fa fa-thumbs-o-down"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="text-center">
                                <?php echo $this->session->flashdata('error'); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <section class="content">
                     <?php echo @$content_for_layout; ?>
                </section>
            </aside>
        </div>

        
        <script src="<?php echo PLUGIN_URL; ?>summernote/summernote.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>sweet-alert/sweet-alert.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>datepicker/bootstrap-datepicker.js"></script>
        
        <script src="<?php echo ADMIN_JS_URL; ?>bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo ADMIN_JS_URL; ?>app.js" type="text/javascript"></script>
    </body>
    </html>