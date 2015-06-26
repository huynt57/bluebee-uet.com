<?php

class AboutUsController extends Controller {

//     public function beforeAction() {
//        if (Yii::app()->session['token'] == '')
//            $this->redirect('welcomePage');
//    }

    public function actionIndex() {

        $this->actionAboutUs();
    }

    public function actionAboutUs() {
        $this->pageTitle = "Bluebee - UET | Về chúng tôi";
        Yii::app()->clientScript->registerMetaTag("Bluebee - UET | Về chúng tôi", null, null, array('property' => 'og:title'));
        $this->render('AboutUs');
    }

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
