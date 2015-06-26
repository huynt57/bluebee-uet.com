<?php

Yii::import('application.controllers.BaseController');

class ShareController extends BaseController {

//    public function beforeAction() {
//        if (Yii::app()->session['token'] == '')
//            $this->redirect('welcomePage');
//    }
    public function actionIndex() {
//        if (Yii::app()->session['token'] == "")
//            $this->redirect('welcomePage');
        $this->actionShare();
    }

    public function listCategoryFather() {
        $category_father = Faculty::model()->findAll();
        return $category_father;
    }

    public function listSubjectType() {
        $subject_type = SubjectType::model()->findAll();
        return $subject_type;
    }

    public function actionShare() {
        $this->render('share');
    }

    public function actionTeacher() {
        if (isset($_GET["id"])) {
            $id = StringHelper::filterString($_GET["id"]);

            $spCriteria = new CDbCriteria();
            $spCriteria->select = "*";
            $spCriteria->condition = "teacher_id = :teacher_id";
            $spCriteria->params = array(':teacher_id' => $id);

            $teacher_current_id = Teacher::model()->findAll($spCriteria);

            $subject_teacher = Subject::model()->with(array('subject_teacher' => array(
                            'select' => false,
                            'condition' => 'teacher_id = :teacher_id',
                            'params' => array(':teacher_id' => $id),
                )))->findAll();

            $ratingCriteria = new CDbCriteria();
            $ratingCriteria->select = "*";
            $ratingCriteria->condition = "teacher_id = :teacher_id";
            $ratingCriteria->params = array(":teacher_id" => $id);
            $rating = Votes::model()->findAll($ratingCriteria);
            $count = count($rating);

            if ($teacher_current_id) {
                foreach ($teacher_current_id as $detail):
                    $title = $detail->teacher_acadamic_title . " " . $detail->teacher_name . "| Bluebee - UET";
                    $image = $detail->teacher_avatar;
                    $des = $detail->teacher_description;
                    $this->pageTitle = $title;

                    Yii::app()->clientScript->registerLinkTag("image_src", "image/jpeg", $image);
                    Yii::app()->clientScript->registerMetaTag($title, null, null, array('property' => 'og:title'));
                    Yii::app()->clientScript->registerMetaTag($image, null, null, array('property' => 'og:image'));
                    Yii::app()->clientScript->registerMetaTag($des, null, null, array('property' => 'og:description'));
                endforeach;
                $this->render('teacher', array('teacher_detail_info' => Teacher::model()->findAll($spCriteria),
                    'subject_teacher' => $subject_teacher, 'countVote' => $count));
            }
        }
    }

    public function actionTeacherListPage() {
        $teacher_list = Teacher::model()->findAll();
        $category_father = $this->listCategoryFather();
        $subject_type = $this->listSubjectType();
        $this->pageTitle = "Danh sách giáo viên UET | Bluebee - UET";
        Yii::app()->clientScript->registerMetaTag("Danh sách giáo viên UET | Bluebee - UET", null, null, array('property' => 'og:title'));
        $this->render('teacherListPage', array('teacher_list' => $teacher_list, 'category_father' => $category_father, 'subject_type' => $subject_type));
    }

    public function actionSubject() {
        $this->render('subject');
    }

    public function actionRating() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            $ratingCriteria = new CDbCriteria();
            $ratingCriteria->select = "*";
            $ratingCriteria->condition = "teacher_id = " . StringHelper::filterString($_POST['teacher_id']);
            $rating = Votes::model()->findAll($ratingCriteria);
            $count = count($rating);
            $averageRatingScore = 0;
            $this->retVal->checkRatingStatus = 0;
            foreach ($rating as $rating) {
                $averageRatingScore += $rating["rating_score"];
                if ($rating->user_id == Yii::app()->session['user_id'])
                    $this->retVal->checkRatingStatus = 1;
            }

            if ($this->retVal->checkRatingStatus === 0) {
                $teacher = Teacher::model()->find(array(
                    'select' => '*',
                    'condition' => 'teacher_id = ' . StringHelper::filterString($_POST['teacher_id'])
                ));
                $ratingScore = ($averageRatingScore + $_POST['rating_score']) / ($count + 1);

                $teacher->teacher_rate = round($ratingScore, 1);
                $teacher->save(FALSE);

                $vote = new Votes;
                $vote->teacher_id = StringHelper::filterString($_POST['teacher_id']);
                $vote->user_id = Yii::app()->session['user_id'];
                $vote->rating_score = StringHelper::filterString($_POST['rating_score']);
                $vote->save(FALSE);

                $this->retVal->count = $count + 1;
                $this->retVal->aver = round($ratingScore, 1);
                $this->retVal->score = round($ratingScore);
            } else {
                $this->retVal->message = "Bạn đã đánh giá thầy/cô này.";
            }
        }
        echo CJSON::encode($this->retVal);
        Yii::app()->end();
    }

    public function actionListTeacherDeptFaculty() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'dept_id' => StringHelper::filterString($_POST['dept_id']),
                    'faculty_id' => StringHelper::filterString($_POST['faculty_id']),
                );
                $dept_data = Dept::model()->findAllByAttributes(array('dept_id' => $listSubjectData['dept_id']));
                $teacher_data = Teacher::model()->findAllByAttributes(array('teacher_dept' => $listSubjectData['dept_id'],
                    'teacher_faculty' => $listSubjectData['faculty_id']));
                $this->retVal->teacher_data = $teacher_data;
                $this->retVal->dept_data = $dept_data;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionListTeacherFaculty() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'faculty_id' => StringHelper::filterString($_POST['faculty_id']),
                );
                $faculty_data = Faculty::model()->findAllByAttributes(array('faculty_id' => $listSubjectData['faculty_id']));
                $teacher_data = Teacher::model()->findAllByAttributes(array('teacher_faculty' => $listSubjectData['faculty_id']));
                $this->retVal->teacher_data = $teacher_data;
                $this->retVal->faculty_data = $faculty_data;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionComment() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'teacher_comment' => StringHelper::filterString($_POST['teacher_comment']),
                    'teacher_id' => StringHelper::filterString($_POST['teacher_id'])
                );
                $teacher = new TeacherComment;
                $teacher->teacher_id = $listSubjectData['teacher_id'];
                $teacher->content = $listSubjectData['teacher_comment'];
                if ($teacher->save(FALSE)) {
                    $this->retVal->message = "Bình luận của bạn đã được gửi thành công";
                    $this->retVal->success = 1;
                } else {
                    $this->retVal->message = "Có lỗi xảy ra :(";
                    $this->retVal->success = 0;
                }
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
