<?php

Yii::import('webroot.protected.modules.api.controllers.BaseController');

class SearchController extends BaseController {

    public function actionIndex() {
        $this->actionSearch();
    }

    public function actionSearch() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST['query'])) {
            try {
                $query = StringHelper::filterString($_POST['query']);

                $subject_result = $this->searchSubject($query);
                $teacher_result = $this->searchTeacher($query);
                $doc_result = $this->searchDocument($query);
                $this->retVal->doc_result = $doc_result;
                $this->retVal->subject_result = $subject_result;
                $this->retVal->teacher_result = $teacher_result;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionSearchSubject() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST['query'])) {
            try {
                $query = StringHelper::filterString($_POST['query']);

                $subject_result = $this->searchSubject($query);

                $this->retVal->subject_result = $subject_result;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionSearchTeacher() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST['query'])) {
            try {
                $query = StringHelper::filterString($_POST['query']);

                $teacher_result = $this->searchTeacher($query);

                $this->retVal->teacher_result = $teacher_result;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionSearchDocument() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST['query'])) {
            try {
                $query = StringHelper::filterString($_POST['query']);

                $doc_result = $this->searchDocument($query);

                $this->retVal->doc_result = $doc_result;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function searchSubject($subject_name) {
        $subCriteria = new CDbCriteria;
        $subCriteria->select = "*";
        $subCriteria->addSearchCondition('subject_name', $subject_name);
        $subject_result = Subject::model()->findAll($subCriteria);
        return $subject_result;
    }

    public function searchTeacher($teacher_name) {
        $teacherCriteria = new CDbCriteria;
        $teacherCriteria->select = "*";
        $teacherCriteria->addSearchCondition('teacher_name', $teacher_name);
        $teacher_result = Teacher::model()->findAll($teacherCriteria);
        return $teacher_result;
    }

    public function searchDocument($doc_name) {
        $docCriteria = new CDbCriteria;
        $docCriteria->select = "*";
        $docCriteria->addSearchCondition('doc_name', $doc_name);
        $doc_result = Doc::model()->findAll($docCriteria);
        return $doc_result;
    }

    public function searchUser($user_name) {
        $userCriteria = new CDbCriteria;
        $userCriteria->select = "*";
        $userCriteria->addSearchCondition('user_real_name', $user_name);
        $user_result = User::model()->findAll($userCriteria);
        return $user_result;
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
