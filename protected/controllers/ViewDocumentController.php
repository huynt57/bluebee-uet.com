<?php

class ViewDocumentController extends Controller {
    
    public function actionIndex() {
        $this->actionViewDocument();
    }

    public function actionViewDocument() {
        if (isset($_GET['doc_id'])) {
            $doc_id = StringHelper::filterString($_GET['doc_id']);

            $detail_doc = Doc::model()->findAll(array("select" => "*", "condition" => "doc_id = :doc_id", "params" => array(':doc_id' => $doc_id)));
            $spCriteria = new CDbCriteria();
            $spCriteria->select = "*";
            $spCriteria->condition = "doc_id = :doc_id";
            $spCriteria->params = array(':doc_id' => $doc_id);

            $subject_doc = SubjectDoc::model()->find($spCriteria);

            $spjCriteria = new CDbCriteria();
            $spjCriteria->select = "*";
            $spjCriteria->condition = "subject_id = :subject_id";
            $spjCriteria->params = array(':subject_id' => $subject_doc->subject_id);

            $subject = Subject::model()->find($spjCriteria);

            $related_doc = Doc::model()->findAll(array("select" => "*", "limit" => "3", "order" => "RAND()"));
                       
            foreach ($detail_doc as $detail):
                $title = $detail->doc_name." | Bluebee - UET";
                $this->pageTitle = $title;
                if ($detail->doc_type == 3) {
                    $image = Yii::app()->getBaseUrl(true) . $detail->doc_url;
                } else {
                    $image = $detail->doc_url;
                }
                $des = $detail->doc_description;
                Yii::app()->clientScript->registerMetaTag($title, null, null, array('property' => 'og:title'));
                Yii::app()->clientScript->registerMetaTag($image, null, null, array('property' => 'og:image'));
                Yii::app()->clientScript->registerMetaTag(500, null, null, array('property' => 'og:image:width'));
                Yii::app()->clientScript->registerMetaTag(500, null, null, array('property' => 'og:image:height'));
                Yii::app()->clientScript->registerMetaTag("website", null, null, array('property' => 'og:type'));
                Yii::app()->clientScript->registerMetaTag($des, null, null, array('property' => 'og:description'));

            endforeach;

            $this->render('viewDocument', array('detail_doc' => $detail_doc, 'related_doc' => $related_doc, 'subject' => $subject));
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
