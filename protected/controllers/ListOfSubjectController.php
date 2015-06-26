<?php

Yii::import('application.controllers.BaseController');

class ListOfSubjectController extends BaseController {

    public function actionIndex() {
        $this->pageTitle = "Thông tin chương trình đào tạo | Bluebee - UET  ";
        Yii::app()->clientScript->registerMetaTag("Thông tin chương trình đào tạo | Bluebee - UET ", null, null, array('property' => 'og:title'));
        $this->actionListOfSubject();
    }

    public function listCategoryFather() {
        $category_father = Faculty::model()->findAll();
        return $category_father;
    }

    public function listSubjectType() {
        $subject_type = SubjectType::model()->findAll();
        return $subject_type;
    }

    public function actionListOfSubject() {
        $category_father = $this->listCategoryFather();
        $subject_type = $this->listSubjectType();
        $this->render('listOfSubject', array('category_father' => $category_father, 'subject_type' => $subject_type));
    }

    public function actionInfo() {
        $category_father = $this->listCategoryFather();
        $subject_type = $this->listSubjectType();

        $this->render('info', array('category_father' => $category_father, 'subject_type' => $subject_type));
    }

    public function actionSubject() {
        $subject_id = "";
        if (isset($_GET["subject_id"])) {
            $subject_id = StringHelper::filterString($_GET["subject_id"]);
        } else if (isset($_GET["subject_code"])) {
            $subject_code = StringHelper::filterString($_GET["subject_code"]);
            $subject_by_code = Subject::model()->findByAttributes(array('subject_code' => $subject_code));
            $subject_id = $subject_by_code->subject_id;
        }
        $subjectCriteria = new CDbCriteria();
        $subjectCriteria->select = "*";
        $subjectCriteria->condition = "subject_id = :subject_id";
        $subjectCriteria->params = array(":subject_id" => $subject_id);
        $subject = Subject::model()->findAll($subjectCriteria);

        $teachers = Teacher::model()->with(array("subject_teacher" => array(
                        "select" => false,
                        "condition" => "subject_id = :subject_id",
                        "params" => array(":subject_id" => $subject_id)
            )))->findAll();
//            $doc = Doc::model()->with(array("docs" => array(
//                            "select" => "*",
//                            "condition" => "subject_id = :subject_id and active = 1",
//                            "params" => array(":subject_id" => $subject_id)
//                )))->findAll(array("limit" => "3", "order" => "RAND()"));
//
//            $reference = Doc::model()->with(array("docs" => array(
//                            "select" => "*",
//                            "condition" => "subject_id = :subject_id and active = 0",
//                            "params" => array(":subject_id" => $subject_id)
//                )))->findAll(array("limit" => "3", "order" => "RAND()"));

        $lesson = Lesson::model()->findAll(array("select" => "*", "condition" => "lesson_subject = :lesson_subject",
            "params" => array(":lesson_subject" => $subject_id),
            "order" => "lesson_weeks ASC"));

//            $doc_related = Doc::model()->with(array("docs" => array(
//                            "condition" => "subject_id = :subject_id",
//                            "params" => array(":subject_id" => $subject_id)
//                )))->findAll();
        //   $sql = "SELECT * FROM tbl_doc JOIN tbl_subject_doc ON tbl_doc.doc_id = tbl_subject_doc.doc_id WHERE tbl_subject_doc.subject_id = " . $subject_id;
        // $doc_related = Yii::app()->db->createCommand($sql)->query();

        $criteria = new CDbCriteria;
        $criteria->select = 't.*';
        $criteria->join = 'JOIN tbl_subject_doc ON t.doc_id = tbl_subject_doc.doc_id';
        $criteria->condition = 'tbl_subject_doc.subject_id = :value';
        $criteria->params = array(":value" => $subject_id);

        $doc_related = Doc::model()->findAll($criteria);

//            $doc_related = SubjectDoc::model()->findAll(array(
//                'select' => '*',
//                'condition' => 'subject_id = :subject_id',
//                'params' => array(':subject_id' => $subject_id)));
        
        foreach ($subject as $subject_detail):
            $title = $subject_detail->subject_name . " | Bluebee - UET";
            $des = $subject_detail->subject_target;
        endforeach;
        $this->pageTitle = $title;
        Yii::app()->clientScript->registerMetaTag($title, null, null, array('property' => 'og:title'));
        Yii::app()->clientScript->registerMetaTag(Yii::app()->createAbsoluteUrl('listOfSubject/subject?subject_id=') . $subject_id, null, null, array('property' => 'og:url'));
        Yii::app()->clientScript->registerMetaTag($des, null, null, array('property' => 'og:description'));
        $category_father = Faculty::model()->findAll();
        $subject_type = SubjectType::model()->findAll();
        $this->render('subject', array('subject' => $subject, 'category_father' => $category_father,
            'subject_type' => $subject_type, 'teacher' => $teachers,
            'lesson' => $lesson, 'doc_related' => $doc_related));
    }

    public function actionCourseOfStudy() {
        $category_father = $this->listCategoryFather();
        $subject_type = $this->listSubjectType();
        $this->render('courseOfStudy', array('category_father' => $category_father, 'subject_type' => $subject_type));
    }

    public function actionDeptInfoView() {
        $this->retVal = new stdClass();
        $html = $this->renderPartial('courseOfStudyhtml', FALSE);

        echo $html;
        Yii::app()->end();
    }

    public function actionFacultyInfoView() {
        $this->retVal = new stdClass();
        $html = $this->renderPartial('departmenthtml', FALSE);
        echo $html;
        Yii::app()->end();
    }

    public function actionDeptInfo() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'dept_id' => StringHelper::filterString($_POST['dept_id']),
                    'faculty_id' => StringHelper::filterString($_POST['faculty_id']),
                );
                $dept_data = Dept::model()->findAllByAttributes(array('dept_id' => $listSubjectData['dept_id'],
                    'dept_faculty' => $listSubjectData['faculty_id']));
                $this->retVal->dept_data = $dept_data;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionListOfSubjectInfoView() {
        $this->retVal = new stdClass();
        $html = $this->renderPartial('listOfSubjecthtml', FALSE);

        echo $html;
        Yii::app()->end();
    }

    public function actionListOfSubjectInfo() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'subject_dept' => StringHelper::filterString($_POST['subject_dept']),
                    'subject_faculty' => StringHelper::filterString($_POST['subject_faculty']),
                    'subject_type' => StringHelper::filterString($_POST['subject_type']),
                    'dept_id' => StringHelper::filterString($_POST['subject_dept']),
                    'faculty_id' => StringHelper::filterString($_POST['subject_faculty']),
                );
                $subject_data = Subject::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty'] . ' AND subject_type = ' . $listSubjectData['subject_type'] . ' AND (subject_general_faculty_id = ' . $listSubjectData['faculty_id'] . ' OR subject_dept = ' . $listSubjectData['subject_dept'] . ')'));
                $subject_type_group = SubjectGroupType::model()->findAllByAttributes(array('subject_group' => $listSubjectData['subject_type'],
                    'subject_dept' => $listSubjectData['subject_dept'], 'subject_faculty' => $listSubjectData['subject_faculty']));
//                var_dump($subject_data);
//                                exit();
                $subject_type_name = SubjectType::model()->findAllByAttributes(array('id' => $listSubjectData['subject_type']));
                $this->retVal->subject_data = $subject_data;
                $this->retVal->subject_group_type = $subject_type_group;
                $dept_data = Dept::model()->findAllByAttributes(array('dept_id' => $listSubjectData['dept_id'],
                    'dept_faculty' => $listSubjectData['faculty_id']));

                $this->retVal->subject_type = $subject_type_name;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionFacultyInfo() {
        $category_father = $this->listCategoryFather();
        $subject_type = $this->listSubjectType();
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'faculty_id' => StringHelper::filterString($_POST['faculty_id']),
                );
                $faculty_data = Faculty::model()->findAllByAttributes(array(
                    'faculty_id' => $listSubjectData['faculty_id']));
                $sql = "SELECT * FROM tbl_teacher_faculty_position INNER JOIN tbl_teacher ON tbl_teacher_faculty_position.teacher_id = tbl_teacher.teacher_id WHERE tbl_teacher_faculty_position.teacher_id = '" . $listSubjectData['faculty_id'] . "'";
                $teacher_faculty_position = Yii::app()->db->createCommand($sql)->queryAll();

                $this->retVal->faculty_data = $faculty_data;
                $this->retVal->teacher_faculty_position = $teacher_faculty_position;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

}
