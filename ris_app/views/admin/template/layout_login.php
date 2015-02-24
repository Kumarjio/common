<!DOCTYPE html>
<html lang="en" class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo @$page_title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link href="<?php echo ADMIN_CSS_URL; ?>bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo ASSETS_URL; ?>fonts/stylesheet.css" rel="stylesheet" />
        <link href="<?php echo ADMIN_CSS_URL; ?>style.css" rel="stylesheet" rel="stylesheet" />
        <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet" rel="stylesheet" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo ADMIN_JS_URL; ?>jquery.min.js"></script>
        <script src="<?php echo ADMIN_JS_URL; ?>jquery.validate.js"></script>

         <script type="text/javascript">
            var http_host_js = '<?php echo ADMIN_URL; ?>';
        </script>
    </head>

    <body class="login bg-black">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <h1 class="login-logo"><?php echo $this->config->item('app_name'); ?></h1>    
        </div>  
    </div>

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

    <?php echo @$content_for_layout; ?>
        
    <!-- Bootstrap -->
    <script src="<?php echo ADMIN_JS_URL; ?>bootstrap.min.js" type="text/javascript"></script>
    
    </body>
</html>