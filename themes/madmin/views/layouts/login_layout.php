<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <!-- EX -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <title><?php echo $this->pageTitle; ?></title>
        <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
            <!-- Apple devices fullscreen -->
            <meta name="apple-mobile-web-app-capable" content="yes" />
            <!-- Apple devices fullscreen -->
            <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

            <!-- Favicon -->
            <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/favicon.ico" />
            <!-- Apple devices Homescreen icon -->
            <link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/apple-touch-icon-precomposed.png" />
            <style>
                label, th, td
                {
                    font-weight: normal;
                }
                textarea
                {
                    resize:vertical;
                }
            </style>
    </head>
    <body>
        <div id="utter-wrapper" class="color-skin-1">
            <header id="header" class="header" data-offset-top="10">
                <nav id="topbar" role="navigation" style="margin-bottom: 0; z-index: 2;" class="navbar navbar-default navbar-static-top">
                    <div class="navbar-header">
                        <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span></button>
                        <a id="logo" href="<?php $this->md("", true) ?>" class="navbar-brand">
                            <span class="fa fa-rocket"></span>
                            <span class="logo-text" style="font-size:22px;">Bluebee-UET</span>
                            <span style="display: none" class="logo-text-icon">µ</span>
                        </a>
                    </div>
                    <div class="topbar-main">

                        <ul class="nav navbar navbar-top-links navbar-right mbn">
                            <?php if ($this->hasLoggedIn()): ?>
                                <li class="dropdown topbar-user">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="https://s3.amazonaws.com/uifaces/faces/twitter/kolage/48.jpg" alt="" class="img-responsive img-circle" />
                                        &nbsp;<span class="hidden-xs"><?php echo $this->getUsername() ?></span>
                                        &nbsp;<span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user pull-right">
                                        <li><a href="<?php echo $this->getLogoutUrl() ?>"><i class="fa fa-key"></i>Log Out</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- /#header -->
            <div id="wrapper-full" class="the-body">
                <div id="page-wrapper-full">
                    <div class="row">
                
                        <div class="col-lg-12">
                            <?php echo $content ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer">
                <div class="copyright"><?php echo date("Y") ?> © Bluebee - bluebee-uet.com</div>
            </div>
            <script>
                $(function() {
                    var $theBody = $(".the-body");
                    var wdHeight = window.innerHeight;
                    var ftHeight = $("#footer").get(0).offsetHeight;
                    var hdHeight = $("#header").get(0).offsetHeight;
                    $theBody.css("min-height", wdHeight - hdHeight - ftHeight);
                    console.log(wdHeight - hdHeight - ftHeight)
                });
            </script>
    </body>
</html>
