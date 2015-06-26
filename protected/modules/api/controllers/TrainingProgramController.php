<?php

Yii::import('webroot.protected.modules.api.controllers.BaseController');

class TrainingProgramController extends BaseController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionGetFacultyInfo() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $faculty_id = $request->getPost('faculty_id');
                $faculty_data = Faculty::model()->findAllByAttributes(array('faculty_id' => $faculty_id));
                $this->retVal->faculty_data = $faculty_data;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionGetDeptInfo() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $faculty_id = $request->getPost('faculty_id');
                $dept_id = $request->getPost('dept_id');
                $dept_data = Dept::model()->findAllByAttributes(array('dept_id' => $dept_id, 'dept_faculty' => $faculty_id));
                $this->retVal->dept_data = $dept_data;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
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
