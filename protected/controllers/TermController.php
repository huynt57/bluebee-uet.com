<?php

class TermController extends Controller {
    public function actionIndex() {
        $this->actionTerm();
    }

    public function actionTerm() {
        $this->pageTitle = "Điều khoản sử dụng | Bluebee - UET";
        Yii::app()->clientScript->registerMetaTag("Điều khoản sử dụng | Bluebee - UET", null, null, array('property' => 'og:title'));
        $this->render('term');
    }
}
