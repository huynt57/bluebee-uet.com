<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <title><?php echo $this->pageTitle; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

      
        <meta name="author" content="Bluebee Team">

            <meta name="google-play-app" content="app-id=com.uet.bluebee">

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
                <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/basic.css" />
                <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/component.css" />
                <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/pace-theme-mac-osx.css" />
                <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/token-input-facebook.css" />
                <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/ratings.css" />
                <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/post_style.css">
                    <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/search_style.css">
                        <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/documentpage.css">
                            <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.smartbanner.css" rel="stylesheet" type="text/css"/>
                            <link rel="icon" type="image/png"  href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/16fv.ico">
                                <!-- javascript -->
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery-1.9.1.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.jcarousel.min.js"></script>

                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/g-alert.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.carousello.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.flexslider.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.isotope.js"></script>


                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.simpleplaceholder.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.smoothScroll.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.themepunch.revolution.min.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.dropdown-menu.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/navToSelect.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/plugins.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/waypoints.min.js"></script>

                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-search.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-tabs.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-timeline.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/modernizr.custom.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/w-switcher.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.magnific-popup.min.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.tokeninput.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/classie.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/cbpScroller.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.form.min.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.paginate.min.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/script.js"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/pace.min.js"></script>

                                <script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.smartbanner.js" type="text/javascript"></script>
                                <!-- Star rating-->


                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.barrating.js"></script>
                                <script type="text/javascript">
                                    function updateKey(alias) {
                                        var str = alias;
                                        str = str.toLowerCase();
                                        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ  |ặ|ẳ|ẵ/g, "a");
                                        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
                                        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
                                        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
                                        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
                                        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
                                        str = str.replace(/đ/g, "d");
                                        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
                                        /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
                                        str = str.replace(/-+-/g, "-"); //thay thế 2- thành 1-
                                        str = str.replace(/^\-+|\-+$/g, "");
                                        str = str.replace(/\s/g, "-");
                                        //cắt bỏ ký tự - ở đầu và cuối chuỗi 
                                        return str;

                                    }
                                </script>
                                <script type="text/javascript">
                                     $(function() { $.smartbanner({
                                        title: 'Ứng dụng Bluebee Android',
                                        price: 'MIỄN PHÍ', // Price of the app
                                        appStoreLanguage: 'Vi', // Language code for App Store
                                        icon: 'https://lh3.ggpht.com/x9UjqlK3lO-Qfci_7Ygt_LX4RH3GI1RorBhCzBtSqa3k8IoZhluhZyQQIgzqfBBYtprU=w300-rw',
                                        inGooglePlay: 'Trên Google Play', // Text of price for Android
                                       
                                        button: 'TẢI !', // Text on the install button
                                        scale: 'auto', // Scale based on viewport size (set to 1 to disable)
                                        speedIn: 300, // Show animation speed of the banner
                                        speedOut: 400, // Close animation speed of the banner
                                        daysHidden: 15, // Duration to hide the banner after being closed (0 = always show banner)
                                        daysReminder: 90, // Duration to hide the banner after "VIEW" is clicked (0 = always show banner)
                                        
                                    }) } );
                                   
                                </script>
                                <script type="text/javascript">
                                    jQuery(document).ready(function($) {
                                        $('#popupad').hide();
                                        $('#popuptks').hide();
                                        // Get current url
                                        // Select an a element that has the matching href and apply a class of 'active'. Also prepend a - to the content of the link

                                        var url = window.location.href;
                                        $('a[href="' + url + '"]').parent().parent().addClass('active');


                                    });
                                </script>

                                <script type="text/javascript">
                                    $(function() {
                                        $('#example-f').barrating({showSelectedRating: false, readonly: true});
                                    });
                                </script>
                                <!-- Pop-up -->
                                <script>
                                    $(document).ready(function() {
                                        $('.novaCat').on('blur', function(ui, event) {
                                            var valor = $('.novaCat').val();
                                            if (valor) {
                                                $('#novaCategoria').dialog({
                                                    modal: true,
                                                    resizable: false,
                                                    buttons: {
                                                        "OK": function() {
                                                            $(this).dialog("close");
                                                        }
                                                    }
                                                });
                                            }
                                            ;
                                        });
                                        //formulário popup
                                        $('.popup-with-form').magnificPopup({
                                            type: 'inline',
                                            preloader: false,
                                            focus: '#name',
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
                                <!-- GMap-->
                                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jquery.gmap.min.js"></script>

                                <script type="text/javascript">var switchTo5x = true;</script>
                                </head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
                                <body class="l-body home" style="background-color: #ecf0f1">
                                    <div id="fb-root"></div>
                                    <script>(function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (d.getElementById(id))
                                                return;
                                            js = d.createElement(s);
                                            js.id = id;
                                            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.0";
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));</script>
                                    <style>
                                        #fan_page_fb {
                                            position: fixed;
                                            z-index: 1000000;
                                            height: 271px;
                                            width: 300px;
                                            background-color: white;
                                            top: 58%;
                                            left: -300px;
                                            -moz-transition: background 0.1s ease-in;
                                            -o-transition: background 0.1s ease-in;
                                            -webkit-transition: background 0.1s ease-in;
                                            transition: left 1s ease-in;
                                        }

                                        #button_like_fanpage_fb {
                                            position: absolute;
                                            right: -33%;
                                            top: 19%;
                                            transform: rotate(90deg);
                                            background-color: #429edb;
                                            font-size: 15px;
                                            color: white;
                                            height: 50px;
                                            width: 150px;
                                            font-family: 'Open sans';
                                            text-align: center;
                                            border-radius: 4px 4px 0 0;
                                            -moz-transition: background 0.1s ease-in;
                                            -o-transition: background 0.1s ease-in;
                                            -webkit-transition: background 0.1s ease-in;
                                            transition: left 1s ease-in;
                                            cursor: pointer;
                                        }
                                    </style>


                                    <!-- CANVAS -->
                                    <div class="l-canvas col_cont headerpos_fixed headertype_extended type_boxed">
                                        <div class="l-canvas-h">

                                            <!-- HEADER -->
                                            <div class="l-header" style="z-index: 1">
                                                <div class="l-header-h">
                                                    <div class="l-subheader at_top" style="background-image: url('<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/header.jpg')">
                                                    </div>

                                                    <div class="l-subheader at_middle">
                                                        <div class="l-subheader-h i-cf">
                                                            <!-- LOGO -->
                                                            <div class="w-logo">
                                                                <div class="w-logo-h">
                                                                    <a class="w-logo-link" href="<?php echo Yii::app()->createUrl("home") ?>" class="w-nav-anchor level_1">
                                                                        <img class="w-logo-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/logo.jpg" alt="BlueBee" />
                                                                        <span class="w-logo-title">
                                                                            <span class="w-logo-title-h">BlueBee</span>
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </div>


                                                            <div class="w-search submit_inside">
                                                                <div class="w-search-h">
                                                                    <a class="w-search-show" href="javascript:void(0)" style="margin: auto;">
                                                                        <i class="icon-search" style="line-height: inherit"></i>
                                                                    </a>

                                                                    <form class="w-search-form show_hidden" action="<?php echo Yii::app()->createUrl('search') ?>" method="get"  />
                                                                    <div class="w-search-input">
                                                                        <input type="text" value="" placeholder="Bạn muốn tìm gì ?" id="input_search" name="query"/>
                                                                    </div>
                                                                    <div class="w-search-submit" >
                                                                        <input type="submit" value="Tìm kiếm"/>

                                                                    </div>
                                                                    <a class="w-search-close" href="javascript:void(0)" title="Đóng tìm kiếm"> &#10005; </a>
                                                                    </form>
                                                                </div>
                                                            </div>



                                                            <!-- NAV -->
                                                            <nav class="w-nav ">
                                                                <div class="w-nav-h align_center">
                                                                    <div class="w-nav-select">
                                                                        <select class="w-nav-select-h">
                                                                        </select>
                                                                    </div>
                                                                    <div class="w-nav-list layout_hor width_auto float_right level_1">
                                                                        <div class="w-nav-list-h">
                                                                            <div class="w-nav-item level_1">
                                                                                <div class="w-nav-item-h">
                                                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl("listOfSubject") ?>" class="w-nav-anchor level_1 menu-header">
                                                                                        <span class="w-nav-icon"><i class="icon-star"></i></span>
                                                                                        <span class="w-nav-title">Chương trình đào tạo</span>
                                                                                        <span class="w-nav-hint"></span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-nav-item level_1">
                                                                                <div class="w-nav-item-h">
                                                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl("document") ?>" class="w-nav-anchor level_1 menu-header">
                                                                                        <span class="w-nav-icon"><i class="icon-star"></i></span>
                                                                                        <span class="w-nav-title">Đề thi - Tài liệu</span>
                                                                                        <span class="w-nav-hint"></span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-nav-item level_1">
                                                                                <div class="w-nav-item-h">
                                                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl("lab") . "/" ?>" class="w-nav-anchor level_1 menu-header">
                                                                                        <span class="w-nav-icon"><i class="icon-star"></i></span>
                                                                                        <span class="w-nav-title">Lab - Tài liệu nén</span>
                                                                                        <span class="w-nav-hint"></span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-nav-item level_1">
                                                                                <div class="w-nav-item-h">
                                                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl("share/teacherListPage") ?>" class="w-nav-anchor level_1 menu-header">
                                                                                        <span class="w-nav-icon"><i class="icon-star"></i></span>
                                                                                        <span class="w-nav-title">Giảng viên</span>
                                                                                        <span class="w-nav-hint"></span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>

                                                                            <div class="w-nav-item level_1">
                                                                                <div class="w-nav-item-h">
                                                                                    <a href="https://play.google.com/store/apps/details?id=com.uet.bluebee" class="w-nav-anchor level_1 menu-header">
                                                                                        <span class="w-nav-icon"><i class="icon-star"></i></span>
                                                                                        <span class="w-nav-title">Android App</span>
                                                                                        <span class="w-nav-hint"></span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>

                                                                            <?php
                                                                            if (Yii::app()->session["user_id"] == "") {
                                                                                echo '


        <a style="margin:10px" id="login" href="' . $this->createUrl('welcomePage/fb_login') . '"><i class="icon-facebook"></i> Đăng nhập</a>
    ';
                                                                            } else {
                                                                                echo '
                                                                <div class="w-nav-item level_1">
    <div class="w-nav-item-h">
        <a href="' . Yii::app()->createUrl("user?token=" . Yii::app()->session['token']) . '" class="w-nav-anchor level_ava">
            <img style="border: 5px solid white;"class="ava" src="' .
                                                                                Yii::app()->session['user_avatar']
                                                                                . '"/>
        </a>


        <div class="w-nav-list place_down show_onhover level_2">
            <div class="w-nav-list-h">
                <div class="w-nav-item level_2">
                    <div class="w-nav-item-h">
                        <a href="' . Yii::app()->createUrl('welcomePage/logout') . '" class="w-nav-anchor level_2">Đăng xuất</a>
                    </div>
                </div>
                <!--                                                            <div class="w-nav-item level_2">
                                                                                <div class="w-nav-item-h">
                                                                                    <a href="home-parallax.html" class="w-nav-anchor level_2">Cập nhật thông tin</a>
                                                                                </div>
                                                                            </div>-->

            </div>
        </div>

    </div>
</div>'
                                                                                ;
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                            </nav>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                            <!-- MAIN -->
                                            <div style="padding-top: 126px; z-index: 0; position: relative;">

                                                <?php echo $content; ?>

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
                                                        <div class="w-copyright">© 2014 All rights reserved. <a href='bluebee-uet.com'>BlueBee Team - K57CA - UET</a></div>

                                                        <!-- NAV -->
                                                        <nav class="w-nav">
                                                            <div class="w-nav-h">
                                                                <div class="w-nav-list layout_hor width_auto float_right level_1">
                                                                    <div class="w-nav-list-h">
                                                                        <div class="w-nav-item level_1">
                                                                            <div class="w-nav-item-h">
                                                                                <a href="<?php echo Yii::app()->createUrl("term") ?>" class="w-nav-anchor level_1">Điều khoản và dịch vụ</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-nav-item level_1">
                                                                            <div class="w-nav-item-h">
                                                                                <a href="<?php echo Yii::app()->createUrl("faq") ?>" class="w-nav-anchor level_1">FAQ</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-nav-item level_1">
                                                                            <div class="w-nav-item-h">
                                                                                <a href="http://blog.bluebee-uet.com" class="w-nav-anchor level_1">Blog</a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="w-nav-item level_1">
                                                                            <div class="w-nav-item-h">
                                                                                <a href="<?php echo Yii::app()->createUrl("aboutUs") ?>" class="w-nav-anchor level_1">Về chúng tôi</a>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </nav>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>


                                        <!-- /FOOTER -->

                                        <a class="w-toplink" href="#"><i class="icon-angle-up" style="line-height: inherit"></i></a>
                                    </div>
                                </body>
                                </html>

                                <script>
                                    (function(i, s, o, g, r, a, m) {
                                        i['GoogleAnalyticsObject'] = r;
                                        i[r] = i[r] || function() {
                                            (i[r].q = i[r].q || []).push(arguments)
                                        }, i[r].l = 1 * new Date();
                                        a = s.createElement(o),
                                                m = s.getElementsByTagName(o)[0];
                                        a.async = 1;
                                        a.src = g;
                                        m.parentNode.insertBefore(a, m)
                                    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                                    ga('create', 'UA-55422921-1', 'auto');
                                    ga('send', 'pageview');

                                </script>