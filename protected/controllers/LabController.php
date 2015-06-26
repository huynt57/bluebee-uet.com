<?php

Yii::import('application.controllers.BaseController');

class LabController extends BaseController {

//     public function beforeAction() {
//        if (Yii::app()->session['token'] == '')
//            $this->redirect('welcomePage');
//    }
    public static $cnt = 1;

    public function actionIndex() {

        //    $this->redirect('welcomePage');
        $this->pageTitle = "Lab UET | Bluebee - UET";
        Yii::app()->clientScript->registerMetaTag("Lab UET | Bluebee - UET", null, null, array('property' => 'og:title'));
        $this->actionLab();
    }

    public function listCategoryFather() {
        $category_father = Faculty::model()->findAll();
        return $category_father;
    }

    public function listSubjectType() {
        $subject_type = SubjectType::model()->findAll();
        return $subject_type;
    }

    public function actionLab() {
        //  Yii::app()->clientScript->registerMetaTag('foo, bar', 'keywords');
        $category_father = $this->listCategoryFather();
        $subject_type = $this->listSubjectType();
        $subject = Subject::model()->findAll(array('order' => "subject_name"));
        $Criteria = new CDbCriteria(); //represent for query such as conditions, ordering by, limit/offset.
        $this->render('document', array('category_father' => $category_father, 'subject_type' => $subject_type, 'subject_info' => $subject));
    }

    public function actionListDocument() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'subject_dept' => StringHelper::filterString($_POST['subject_dept']),
                    'subject_faculty' => StringHelper::filterString($_POST['subject_faculty']),
                    'subject_type' => StringHelper::filterString($_POST['subject_type']),
                );
                $subject_data = Subject::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty'] . ' AND subject_type = ' . $listSubjectData['subject_type'] . ' AND (subject_general_faculty_id = ' . $listSubjectData['subject_faculty'] . ' OR subject_dept = ' . $listSubjectData['subject_dept'] . ')'
                    , 'order' => 'subject_name ASC'));
                $doc_data = Doc::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty'] . ' AND doc_type = 3 AND subject_type = ' . $listSubjectData['subject_type'] . ' AND (subject_general_faculty_id = ' . $listSubjectData['subject_faculty'] . ' OR subject_dept = ' . $listSubjectData['subject_dept'] . ')',
                    'order' => 'doc_id DESC'));
                $this->retVal->subject_data = $subject_data;
                $this->retVal->doc_data = $doc_data;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionListDocumentDept() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'subject_dept' => StringHelper::filterString($_POST['subject_dept']),
                    'subject_faculty' => StringHelper::filterString($_POST['subject_faculty']),
                );
                $subject_data = Subject::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty'] . ' AND (subject_general_faculty_id = ' . $listSubjectData['subject_faculty'] . ' OR subject_dept = ' . $listSubjectData['subject_dept'] . ')',
                    'order' => 'subject_name ASC'));
                $doc_data = Doc::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty'] . ' AND doc_type = 3 AND (subject_general_faculty_id = ' . $listSubjectData['subject_faculty'] . ' OR subject_dept = ' . $listSubjectData['subject_dept'] . ')',
                    'order' => 'doc_id DESC'));
                $this->retVal->subject_data = $subject_data;
                $this->retVal->doc_data = $doc_data;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionListDocumentFaculty() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $listSubjectData = array(
                    'subject_faculty' => StringHelper::filterString($_POST['subject_faculty']),
                );
                $subject_data = Subject::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty']
                    , 'order' => 'subject_name ASC'));
                $doc_data = Doc::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty'] . ' AND doc_type = 3'
                    , 'order' => 'doc_id DESC',
                ));
                $this->retVal->subject_data = $subject_data;
                $this->retVal->doc_data = $doc_data;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionViewDocument() {
        $this->render('viewdocument');
    }

    public function saveDoc($doc_name, $doc_description, $doc_url, $doc_author, $subject_id, $doc_scribd_id, $doc_type, $doc_path, $doc_author_name) {

        $doc_data = Subject::model()->findByAttributes(array('subject_id' => $subject_id));

        $doc_model = new Doc;
        $doc_model->doc_name = $doc_name;
        $doc_model->doc_description = $doc_description;
        $doc_model->doc_url = $doc_url;
        $doc_model->subject_type = $doc_data->subject_type;
        $doc_model->doc_path = $doc_path;
        $doc_model->subject_faculty = $doc_data->subject_faculty;
        $doc_model->subject_dept = $doc_data->subject_dept;
        $doc_model->subject_general_faculty_id = $doc_data->subject_general_faculty_id;
        $doc_model->doc_scribd_id = $doc_scribd_id;
        $doc_model->doc_type = $doc_type;
        $doc_model->doc_status = 1;
        $doc_model->doc_author_name = $doc_author_name;
        $doc_model->doc_author = $doc_author;
        $doc_model->save(FALSE);
        $doc_subject = new SubjectDoc;
        $doc_subject->doc_id = $doc_model->doc_id;
        $doc_subject->doc_type = $doc_model->doc_type;
        $doc_subject->subject_id = $subject_id;
        $doc_subject->active = 1;
        $doc_subject->save(FALSE);
    }

    public function unicode_str_filter($str) {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }

    public function actionUpload() {
        //$ds = DIRECTORY_SEPARATOR;  //1
        //    $cnt = DocumentController::$cnt++;
        $subject_id = StringHelper::filterString($_POST['subject_id']);
        $size = 100 * 1024 * 1024;
        $doc_name = StringHelper::filterString($_POST['doc_name']);
        $doc_description = StringHelper::filterString($_POST['doc_description']);
        $doc_author = Yii::app()->session['user_id'];
        $doc_author_name = Yii::app()->session['user_name'];
        $api_key = "24cxjtv3vw69wu5p7pqd9";
        $secret = "sec-b2rlvg8kxwwpkz9fo3i02mo9vo";
        $this->retVal = new stdClass();
        if ($_FILES['file']) {
            if ($doc_name != "") {
                if ($doc_description != "") {
                    if ($subject_id != "") {
                        if ($_FILES['file']['size'] <= $size) {
                            $scribd = new Scribd($api_key, $secret);
                            $name = $this->unicode_str_filter($_FILES['file']['name']);
                            $storeFolder = Yii::getPathOfAlias('webroot') . '/uploads/document/user_id_' . $doc_author . '/';   //2
                            if (!file_exists($storeFolder)) {
                                mkdir($storeFolder, 0777, true);
                            }
                            $tempFile = $_FILES['file']['tmp_name'];          //3
                            $targetPath = $storeFolder;  //4
                            $targetFile = $targetPath . $name;  //5
                            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                            move_uploaded_file($tempFile, $targetFile); //6
                            $doc_path = Yii::app()->createAbsoluteUrl('uploads') . '/document/user_id_' . $doc_author . '/' . $name;

                            if ($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "pjepg" || $ext == "png" || $ext == "x-png") {
                                $this->saveDoc($doc_name, $doc_description, $doc_path, $doc_author, $subject_id, NULL, 1, $doc_path, $doc_author_name);

                                $this->retVal->url = $targetFile;
                                $this->retVal->doc_name = $doc_name;
                                $this->retVal->doc_path = $doc_path;
                                $this->retVal->user_name = Yii::app()->session['user_name'];
                                $this->retVal->success = 1;
                            } else if ($ext == "doc" || $ext == "docx" || $ext == "ppt" || $ext == "pptx" || $ext == "xls" || $ext == "xlsx" || $ext == 'txt' || $ext == 'pdf') {

                                $upload_scribd = @$scribd->upload($targetFile);

                                $thumbnail_info = array('doc_id' => $upload_scribd["doc_id"],
                                    'method' => NULL,
                                    'session_key' => NULL,
                                    'my_user_id' => NULL,
                                    'width' => '220',
                                    'height' => '250');
                                $get_thumbnail = @$scribd->postRequest('thumbnail.get', $thumbnail_info);
                                // var_dump($get_thumbnail);
                                $this->saveDoc($doc_name . '.' . $ext, $doc_description, @$get_thumbnail["thumbnail_url"], $doc_author, $subject_id, $upload_scribd["doc_id"], 2, $doc_path, $doc_author_name);
                                $this->retVal->docid = @$upload_scribd["doc_id"];
                                $this->retVal->thumbnail = @$get_thumbnail["thumbnail_url"];
                                $this->retVal->doc_name = $doc_name;
                                $this->retVal->doc_path = $doc_path;
                                $this->retVal->user_name = Yii::app()->session['user_name'];
                                $this->retVal->success = 1;
                            } else if ($ext == "html" || $ext == "php" || $ext == "htaccess" || $ext == "js") {
                                $this->retVal->info = "File không được hỗ trợ";
                                $this->retVal->success = 0;
                            } else {
                                $url_file_image = Yii::app()->theme->baseUrl . '/assets/img/document.png';
                                $this->saveDoc($doc_name . "." . $ext, $doc_description, $url_file_image, $doc_author, $subject_id, NULL, 3, $doc_path, $doc_author_name);
                                $this->retVal->doc_url = $url_file_image;
                                $this->retVal->doc_name = $doc_name;
                                $this->retVal->doc_path = $doc_path;
                                $this->retVal->user_name = Yii::app()->session['user_name'];
                                $this->retVal->success = 1;
                            }
                        } else {
                            $this->retVal->message = "Bạn không thể upload file nặng quá 8MB";
                            $this->retVal->success = 0;
                        }
                    } else {
                        $this->retVal->message = "Bạn phải nhập đầy đủ các thông tin";
                        $this->retVal->success = 0;
                    }
                } else {
                    $this->retVal->message = "Bạn phải nhập đầy đủ các thông tin";
                    $this->retVal->success = 0;
                }
            } else {
                $this->retVal->message = "Bạn phải nhập đầy đủ các thông tin";
                $this->retVal->success = 0;
            }
        } else {
            $this->retVal->message = "Bạn phải nhập đầy đủ các thông tin";
            $this->retVal->success = 0;
        }
        echo CJSON::encode($this->retVal);

        Yii::app()->end();
    }

    public function actionFilterDocumentByTime() {

        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $FilerFormData = array(
                    'filter_time' => StringHelper::filterString($_POST['filter_time']),
                );
                $Criteria = new CDbCriteria(); //represent for query such as conditions, ordering by, limit/offset.
                $Criteria->select = "*";
                $Criteria->order = "doc_id " . $FilerFormData['filter_time'];
                $result = Doc::model()->findAll($Criteria);
                $this->retVal = $result;
            } catch (exception $e) {
                // $this->retVal->message = $e->getMessage();
            }
        }
        echo CJSON::encode($this->retVal);
        Yii::app()->end();
    }

    public function actionFilterDocumentBySubject() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $FilerFormData = array(
                    'subject_id' => StringHelper::filterString($_POST['subject_id'])
                );
                $sql = "SELECT * FROM tbl_doc INNER JOIN tbl_subject_doc ON tbl_doc.doc_id = tbl_subject_doc.doc_id WHERE tbl_subject_doc.subject_id = '" . $FilerFormData['subject_id'] . "' AND  tbl_doc.doc_type = 3 ORDER BY tbl_doc.doc_id DESC";
//                var_dump($sql);
//                exit();
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                $this->retVal->doc_data = $result;
            } catch (exception $e) {
                // $this->retVal->message = $e->getMessage();
            }
        }
        echo CJSON::encode($this->retVal);
        Yii::app()->end();
    }

    public function actionSuggestSubjects() {
        $subjects = Yii::app()->db->createCommand()
                ->select('subject_id, subject_name')
                ->from('tbl_subject s')
                ->queryAll();

        foreach ($subjects as $i => $subject) {
            $subjects[$i]["id"] = $subjects[$i]["subject_id"];
            $subjects[$i]["name"] = $subjects[$i]["subject_name"];
        }
        echo CJSON::encode($subjects);
    }

    public function actionFilterSubjectByForm() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $array_subject_id = $_POST['subjects'];
                $subject_name = array();
                $array = explode(",", $array_subject_id);
                foreach ($array as $value) {
                    array_push($subject_name, "'" . $value . "'");
                }

                if (count($array_subject_id) > 0) {
                    $sql = "SELECT * FROM tbl_doc INNER JOIN tbl_subject_doc ON tbl_doc.doc_id = tbl_subject_doc.doc_id JOIN tbl_subject ON tbl_subject_doc.subject_id = tbl_subject.subject_id WHERE tbl_subject.subject_name IN (" . join(",", $subject_name) . ") AND tbl_doc.doc_type = 3 ORDER BY tbl_doc.doc_id DESC";
                    $result = Yii::app()->db->createCommand($sql)->queryAll();
                    $this->retVal->doc_data = $result;
                } else {
                    $this->retVal->message = 'Bạn phải nhập môn học đã :))';
                    $this->retVal->success = 0;
                }
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
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
