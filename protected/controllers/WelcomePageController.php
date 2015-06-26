<?php

Yii::import('application.controllers.BaseController');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'class.phpmailer.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'class.pop3.php');
include_once (dirname(__FILE__) . '/../extensions/facebook.php');
Yii::import('ext.ImageResize.imageresize');
Yii::import('application.components.imageresize');

class WelcomePageController extends BaseController {

    public function actionIndex() {
        $this->redirect(Yii::app()->createAbsoluteUrl('listOfSubject'));
    }

    public function actionLogout() {
        $user_current_token = User::model()->findByAttributes(array('user_id' => Yii::app()->session['user_id']));

        if ($user_current_token) {
            $user_current_token->user_token = "";
            $user_current_token->save(FALSE);
        }

        Yii::app()->session['user_id'] = "";
        Yii::app()->session['user_real_name'] = "";
        Yii::app()->session['user_email'] = "";
        Yii::app()->session['token'] = "";
        Yii::app()->session['user_avatar'] = "";

        $this->redirect(Yii::app()->createUrl('index.php'));
    }

    function getFb() {
        $app_id = "1428478800723370";
        $app_secret = "64b21e0ab23ec7db82979f9607065704";
        $site_url = "bluebee-uet.com";

        $facebook = new Facebook(array(
            'appId' => $app_id,
            'secret' => $app_secret,
            "cookie" => true
        ));
        return $facebook;
    }

    public function actionFb_login() {
        // $user = $this->actionFb_login_result();
        //$user_id = User::model()->findByAttributes(array('user_id_fb' => $user["id"]));
        $facebook = $this->getFb();
        $loginUrl = $facebook->getLoginUrl(array(
            'scope' => 'read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos, email',
            //    'redirect_uri' => "http://bluebee-uet.com/user?token=" . $user_id->user_token,
            "redirect_uri" => Yii::app()->createAbsoluteUrl('welcomePage/fb_login_result')
        ));
        $this->redirect($loginUrl);
    }

    public function actionFb_login_result() {
        $facebook = $this->getFb();
        $access_token = $facebook->getAccessToken();
        $user = $facebook->api("me", "get", array(
            "access_token" => $access_token
        )); //check login tai day
        //print_r($user["id"]);
        //die();
        $user_facebook_exist = User::model()->findByAttributes(array('user_id_fb' => $user["id"]));
        if ($user_facebook_exist) {
            $token = StringHelper::generateToken(16, 36);
            $user_facebook_exist->user_token = $token;
            if (isset($user["name"])) {
                $user_facebook_exist->user_real_name = $user['name'];
            }
            if (isset($user["email"])) {
                $user_facebook_exist->username = $user['email'];
            }

            if (isset($user["quotes"])) {
                $user_facebook_exist->user_qoutes = $user["quotes"];
            }
            $user_facebook_exist->user_dob = $user["birthday"];
            $user_facebook_exist->user_avatar = "http://graph.facebook.com/" . $user["id"] . "/picture?type=large";
            $user_facebook_exist->user_hometown = @$user["hometown"]["name"];
            $user_facebook_exist->user_active = 1;
            $user_facebook_exist->save(FALSE);
            Yii::app()->session['user_avatar'] = $user_facebook_exist->user_avatar;
            Yii::app()->session['user_name'] = $user['name'];
            Yii::app()->session['token'] = $token;
            Yii::app()->session['user_id'] = $user_facebook_exist->user_id;
            $this->redirect(Yii::app()->createUrl('user?token=' . $token));
        } else {
            //   echo 'ok';
            //   die();
            $token = StringHelper::generateToken(16, 36);
            $user_facebook = new User;
            $user["password"] = "bluebee_facebook";
            if (isset($user["name"])) {
                $user_facebook->user_real_name = $user['name'];
            }
            if (isset($user["email"])) {
                $user_facebook->username = $user['email'];
            }
            $user_facebook->user_token = $token;
            $user_facebook->user_dob = $user["birthday"];
            $user_facebook->user_hometown = @$user["hometown"]["name"];
            $user_facebook->user_avatar = "http://graph.facebook.com/" . $user["id"] . "/picture?type=large";
            Yii::app()->session['user_avatar'] = "http://graph.facebook.com/" . $user["id"] . "/picture?type=large";
            Yii::app()->session['token'] = $token;
            Yii::app()->session['user_name'] = $user['name'];
            $user_facebook->user_id_fb = $user["id"];
            $user_facebook->user_active = 1;
            if (isset($user["quotes"])) {
                $user_facebook->user_qoutes = $user["quotes"];
            }
            $user_facebook->user_date_attend = date('d/m/Y');
            $user_facebook->save(FALSE);
            Yii::app()->session['user_id'] = $user_facebook->user_id;
            //return $user;
            $this->redirect(Yii::app()->createUrl('user?token=' . $token));
        }
    }

    public function actionloginFacebook() {
        $app_id = "1428478800723370";
        $app_secret = "64b21e0ab23ec7db82979f9607065704";
        $site_url = "bluebee-uet.com";

        $facebook = new Facebook(array(
            'appId' => $app_id,
            'secret' => $app_secret,
        ));

        $user = $facebook->getUser();

        if ($user) {
            try {
                $user_profile = $facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = NULL;
            }
        }

        if ($user) {
            $logoutUrl = $facebook->getLogoutUrl();
        } else {
            $loginUrl = $facebook->getLoginUrl(array(
                'scope' => 'read_stream, publish_stream, user_birthday, user_hometown, user_photos, email',
                'redirect_uri' => $site_url,
            ));
            $this->redirect($loginUrl);
        }

        if ($user) {
            $queries = array(
                array('method' => 'GET', 'relative_url' => '/' . $user),
                array('method' => 'GET', 'relative_url' => '/' . $user . '/home?limit=50'),
                array('method' => 'GET', 'relative_url' => '/' . $user . '/friends'),
                array('method' => 'GET', 'relative_url' => '/' . $user . '/photos?limit=6'),
            );

            try {
                $batchResponse = $facebook->api('?batch=' . json_encode($queries), 'POST');
            } catch (Exception $o) {
                error_log($o);
            }

            $user_info = json_decode($batchResponse[0]['body'], TRUE);
            $feed = json_decode($batchResponse[1]['body'], TRUE);
            $friends_list = json_decode($batchResponse[2]['body'], TRUE);
            $photos = json_decode($batchResponse[3]['body'], TRUE);
        }
        $this->render('fb');
    }

//    public function actionWelcomePage() {
//        $this->render('index');
//    }
    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
