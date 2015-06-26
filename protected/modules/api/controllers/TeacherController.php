<?php

Yii::import('webroot.protected.modules.api.controllers.BaseController');

class TeacherController extends BaseController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionGetTeacherFaculty() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $faculty_id = $request->getPost('faculty_id');
                $teacher_data = Teacher::model()->findAllByAttributes(array('teacher_faculty' => $faculty_id));
                $this->retVal->teacher_data = $teacher_data;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionGetTeacherDepartment() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $dept_id = $request->getPost('dept_id');
                $faculty_id = $request->getPost('faculty_id');
                $teacher_data = Teacher::model()->findAllByAttributes(array('teacher_dept' => $dept_id, "teacher_faculty" => $faculty_id));
                $this->retVal->teacher_data = $teacher_data;
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
