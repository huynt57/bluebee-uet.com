<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic" />
        <link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700" />

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/motioncss.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/motioncss-widgets.css" />


        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/rs-settings.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/switcher.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/magnific-popup.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/responsive.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/animation.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/colors/color_11.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/ava.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/dropzone.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/basic.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/component.css" />


        <!-- javascript -->
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/g-alert.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.carousello.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.flexslider.js"></script>

        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.isotope.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.magnific-popup.js"></script>

        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.simpleplaceholder.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.smoothScroll.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.themepunch.revolution.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/navToSelect.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/waypoints.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-lang.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-search.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-tabs.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-timeline.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/modernizr.custom.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/dropzone.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-switcher.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/classie.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/cbpScroller.js"></script>

        <!-- Pop-up -->
        <script>
            $(document).ready(function() {
                $('.popup-with-form').magnificPopup({
                    type: 'inline',
                    preloader: false,
                    focus: '#name',
                    // When elemened is focused, some mobile browsers in some cases zoom in
                    // It looks not nice, so we disable it:
                    callbacks: {
                        beforeOpen: function() {
                            if ($(window).width() < 700) {
                                this.st.focus = false;
                            } else {
                                this.st.focus = '#name';
                            }
                        }
                    }
                });
            });
        </script>
    </head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body class="l-body home" style="background-color: white">

    <!-- CANVAS -->
    <div class="l-canvas type_wide col_cont headerpos_fixed headertype_extended">
        <div class="l-canvas-h">

            <!-- HEADER -->
            <div class="l-header">
                <div class="l-header-h">

                    <div class="l-subheader at_middle" style="max-height: 60px">
                        <div class="l-subheader-h i-cf">
                            <!-- LOGO -->
                            <div class="w-logo">
                                <div class="w-logo-h">
                                    <a class="w-logo-link" href="<?php echo Yii::app()->createUrl("") ?>" class="w-nav-anchor level_1">
                                        <img class="w-logo-img" style="padding: 0px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.jpg" alt="BlueBee" />
                                        <span class="w-logo-title">
                                            <span class="w-logo-title-h">BlueBee</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="w-logo">
                                <div class="w-logo-h">
                                    <a class="w-logo-link" href="<?php echo Yii::app()->createUrl("") ?>" class="w-nav-anchor level_1">
                                        <img class="w-logo-img" style="padding: 0px;" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo2.jpg" alt="BlueBee" />
                                        <span class="w-logo-title">
                                            <span class="w-logo-title-h">BlueBee</span>
                                        </span>
                                    </a>
                                </div>
                            </div>

                            <!-- SEARCH -->
                            <div class="w-search submit_inside">
                            </div>

                            <!-- NAV -->
                            <nav class="w-nav ">
                            </nav>

                        </div>
                    </div>

                </div>
            </div>
            <!-- /HEADER -->

            <!-- MAIN -->
            <div class="l-main" style="padding-top: 0px;">
                <?php echo $content; ?>
            </div>
            <!-- /MAIN -->
        </div>
    </div>
    <!-- /CANVAS -->

    <!-- FOOTER -->
    <div class="l-footer type_normal" style="margin-top: 50px;">
        <div class="l-footer-h">
            <!-- subfooter: bottom -->
            <div class="l-subfooter at_bottom">
                <div class="l-subfooter-h i-cf">
                    <div class="w-copyright">© 2014 All rights reserved. <a href='http://us-themes.com/'>BlueBee Team - K57CA - UET</a></div>
                    <!-- NAV -->
                   
                </div>


            </div>
        </div>
    </div>

    <!-- /FOOTER -->

    <a class="w-toplink" href="#"><i class="icon-angle-up" style="line-height: inherit"></i></a>

    <script>
        window.color_scheme = "color_11";
        window.body_layout = "wide";
    </script>
</body>
</html>
