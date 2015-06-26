<?php

class LessonController extends Controller {

    public function actionIndex() {
        $this->actionLesson();
    }

    public function ListDocLesson($lesson_id) {
        $doc_lesson = LessonDoc::model()->findAll(array(
            'select' => "*",
            'condition' => "lesson_id = :lesson_id",
            'params' => array(':lesson_id' => $lesson_id)
        ));
        
        return $doc_lesson;
    }

    public function ListVideoLesson($lesson_id) {
        $vid_lesson = LessonVideo::model()->findAll(array(
            'select' => "*",
            'condition' => "lesson_id = :lesson_id",
            'params' => array(':lesson_id' => $lesson_id)
        ));
        return $vid_lesson;
    }

    public function LessonInfo($lesson_id) {
        $info_lesson = Lesson::model()->findAll(array(
            'select' => "*",
            'condition' => "lesson_id = :lesson_id",
            'params' => array(':lesson_id' => $lesson_id)
        ));
        return $info_lesson;
    }

    public function actionLesson() {
        if (isset($_GET['lesson_id'])) {
            $lesson_id = StringHelper::filterString($_GET['lesson_id']);
            $doc_lesson = $this->ListDocLesson($lesson_id);
            $vid_lesson = $this->ListVideoLesson($lesson_id);
            $info_lesson = $this->LessonInfo($lesson_id);
            foreach ($info_lesson as $detail):
                $title = "Bluebee - UET | " . $detail->lesson_name;
                $this->pageTitle = $title;
                $image = Yii::app()->theme->baseUrl . '/assets/img/document.png';
                $des = $detail->lesson_info;
            endforeach;
            Yii::app()->clientScript->registerMetaTag($title, null, null, array('property' => 'og:title'));
            Yii::app()->clientScript->registerMetaTag($image, null, null, array('property' => 'og:image'));
            Yii::app()->clientScript->registerMetaTag(500, null, null, array('property' => 'og:image:width'));
            Yii::app()->clientScript->registerMetaTag(500, null, null, array('property' => 'og:image:height'));
            Yii::app()->clientScript->registerMetaTag("website", null, null, array('property' => 'og:type'));
            Yii::app()->clientScript->registerMetaTag($des, null, null, array('property' => 'og:description'));

            $this->render('lesson', array('doc_lesson' => $doc_lesson, 'vid_lesson' => $vid_lesson, 'info_lesson' => $info_lesson));
        }
        //  $this->render('lesson');
    }

}
