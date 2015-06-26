<?php

class FAQController extends Controller {
    public function actionIndex() {
        $this->actionFAQ();
    }

    public function actionFAQ() {
         $this->pageTitle = "Bluebee - UET | Hỏi đáp";
        Yii::app()->clientScript->registerMetaTag("Bluebee - UET | Hỏi đáp", null, null, array('property' => 'og:title'));
        $this->render('faq');
    }
}
