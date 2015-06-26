<?php

class SearchController extends CController {

    public function actionIndex() {
        $this->pageTitle = "Bluebee - UET | Tìm kiếm";
        Yii::app()->clientScript->registerMetaTag("Bluebee - UET | Tìm kiếm", null, null, array('property' => 'og:title'));
        $this->actionSearch();
    }

    public function actionSearch() {
        $no_res = "Không tìm thấy kết quả phù hợp";
        if (isset($_GET['query'])) {
            $query = StringHelper::filterString($_GET['query']);

            $subject_result = $this->searchSubject($query);
            $teacher_result = $this->searchTeacher($query);
            $doc_result = $this->searchDocument($query);
            $user_result = $this->searchUser($query);
            $this->render('Search', array('subject_result' => $subject_result, 'teacher_result' => $teacher_result, 'doc_result' => $doc_result,
                'subject_count' => count($subject_result), 'teacher_count' => count($teacher_result), 'doc_count' => count($doc_result),
                'user_result' => $user_result, 'user_count' => count($user_result), 'query' => $query));
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
