<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic" />
        <link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700" />
    </head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<style>
	* {
		margin: 0;
		padding: 0;
	}
    div {
	display: block;
    }
    .fix-margin-div {
	margin: 20px;
	clear: both;
    }
    .body {
	border: 2px solid #429edb;
	margin: 50px auto auto auto;
	border-radius: 5px;
	max-width: 600px;
	font-family: proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif';
    }
    p {
    	font-size: 14px;
    	color: white;
    }
    /*.header {
	border-bottom: 2px dashed #429edb;
    }*/
    .clearfix:after {
	clear: both;
	content: ".";
	display: block;
	height: 0;
	line-height: 0;
	visibility: hidden;
    }
    .logo {
	float: left

    }
    .sub-footer {
	float: right;
    }
    .main {
	clear: both;
	background-color: #429edb;
	min-height: 130px;
    }
    .fix-margin-logo {
	margin: auto;
	float: left;
    }
    a {
    	text-decoration: none;
    }
    button {
    	background-color: white;
    	color: #429edb;
    	border: none;
    	outline: none;
    	height: 50px;
    	width: 80px;
    	margin-left: 10px;
    	font-size: 16px;
    	border-radius: 5px;
    }
</style>
<!-- CANVAS -->
<div class="l-canvas type_wide col_cont headerpos_fixed headertype_extended">
    <div class="l-canvas-h">

        <!-- HEADER -->
        <div class="l-header">
            <div class="l-header-h">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/mail.jpg"/>
            </div>
        </div>




        <!-- FOOTER -->
        <div class="l-footer type_normal">
            <div class="l-footer-h">

                <!-- subfooter: top -->
                <div class="l-subfooter at_top">
                    <div class="l-subfooter-h g-cols cols_fluid">

                        <div class="l-footer-h">
                            This notification has been sent to the email address associated with your website's account. 
                            For information on privacy policy, visit http://blue-bee.uet.com. 
                            This email message was auto-generated. Please do not respond.

                        </div>
                    </div>
                </div>
                <div class="l-subfooter at_bottom">
                    <div class="l-subfooter-h i-cf">
                        <div class='one-fourth'>
                            <img style="float: left" src='<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/logo_1.jpg'/>
                        </div>

                        <div class='three-fourths'>
                            <div class="w-copyright"> © 2014 All rights reserved. <br/> <a href='http://us-themes.com/'>BlueBee Team - K57CA - UET</a></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>


    </div>
</div>

