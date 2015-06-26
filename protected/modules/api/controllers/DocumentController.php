<?php

Yii::import('webroot.protected.modules.api.controllers.BaseController');

class DocumentController extends BaseController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionLatestDocument() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $limit = $request->getPost('limit');
                $sql = "SELECT * FROM tbl_doc JOIN tbl_subject_doc "
                        . "ON tbl_doc.doc_id = tbl_subject_doc.doc_id JOIN "
                        . "tbl_subject ON tbl_subject_doc.subject_id = tbl_subject.subject_id "
                        . "ORDER BY tbl_doc.doc_id DESC LIMIT " . $limit;
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                $this->retVal->doc_data = $result;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionGetFaculty() {
        $this->retVal = new stdClass();
        try {
            $sql = "SELECT * FROM tbl_faculty";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            $this->retVal->faculty_data = $result;
        } catch (exception $e) {
            $this->retVal->message = $e->getMessage();
        }
        echo CJSON::encode($this->retVal);
        Yii::app()->end();
    }

    public function actionGetDepartment() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $faculty_id = $request->getPost('faculty_id');
                $sql = "SELECT * FROM tbl_dept WHERE dept_faculty = '" . $faculty_id . "'";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                $this->retVal->dept_data = $result;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionGetSubject() {
        $this->retVal = new stdClass();
        //      $request = Yii::app()->request;

        try {
            //      $faculty_id = $request->getPost('faculty_id');
            //    $dept_id = $request->getPost('dept_id');
//                $sql = "SELECT * FROM tbl_subject JOIN tbl_faculty "
//                        . "ON tbl_subject.subject_faculty = tbl_faculty.faculty_id JOIN tbl_dept "
//                        . "ON tbl_subject.subject_dept = tbl_dept.dept_id";
            $sql = "SELECT subject_id, subject_name FROM tbl_subject";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            $this->retVal->subject_data = $result;
        } catch (exception $e) {
            $this->retVal->message = $e->getMessage();
        }
        echo CJSON::encode($this->retVal);
        Yii::app()->end();
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
//                $subject_data = Subject::model()->findAll(array(
//                    'select' => '*',
//                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty'] . ' AND (subject_general_faculty_id = ' . $listSubjectData['subject_faculty'] . ' OR subject_dept = ' . $listSubjectData['subject_dept'] . ')'
//                    , 'order' => 'subject_name ASC'));
                $doc_data = Doc::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty'] . ' AND (subject_general_faculty_id = ' . $listSubjectData['subject_faculty'] . ' OR subject_dept = ' . $listSubjectData['subject_dept'] . ')'
                    , 'order' => 'doc_id DESC',
                ));
                //        $this->retVal->subject_data = $subject_data;
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
//                $subject_data = Subject::model()->findAll(array(
//                    'select' => '*',
//                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty']
//                    , 'order' => 'subject_name ASC'));
                $doc_data = Doc::model()->findAll(array(
                    'select' => '*',
                    'condition' => 'subject_faculty = ' . $listSubjectData['subject_faculty']
                    , 'order' => 'doc_id DESC',
                ));
                //  $this->retVal->subject_data = $subject_data;
                $this->retVal->doc_data = $doc_data;
                $this->retVal->message = 1;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
    }

    public function actionListDocumentSubject() {
        $this->retVal = new stdClass();
        $request = Yii::app()->request;
        if ($request->isPostRequest) {
            try {
                $subject_id = $request->getPost('subject_id');
                $sql = "SELECT * FROM tbl_doc JOIN tbl_subject_doc ON tbl_doc.doc_id = tbl_subject_doc.doc_id WHERE tbl_subject_doc.subject_id = '" . $subject_id . "'";
                //  $this->retVal->subject_data = $subject_data;
                $doc_data = Yii::app()->db->createCommand($sql)->queryAll();
                $this->retVal->doc_data = $doc_data;
            } catch (exception $e) {
                $this->retVal->message = $e->getMessage();
            }
            echo CJSON::encode($this->retVal);
            Yii::app()->end();
        }
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
        $doc_subject->active = 0;
        $doc_subject->save(FALSE);
    }

    public function actionUpload() {
        //$ds = DIRECTORY_SEPARATOR;  //1
        $subject_id = $_POST['subject_id'];
        
        $size = 100 * 1024 * 1024;
        $doc_name = StringHelper::filterString($_POST['doc_name']);
        $doc_description = StringHelper::filterString($_POST['doc_description']);
        $doc_author =  $_POST['user_id'];
        $doc_author_name = $_POST['username'];
        $api_key = "24cxjtv3vw69wu5p7pqd9";
        $secret = "sec-b2rlvg8kxwwpkz9fo3i02mo9vo";
        $this->retVal = new stdClass();

        if ($_FILES['file']) {
            // print_r ($_FILES['file']);
            if ($doc_name != "") {
                if ($doc_description != "") {
                    if ($subject_id != "") {
                        if ($_FILES['file']['size'] <= $size) {
                            $scribd = new Scribd($api_key, $secret);
                            $name = StringHelper::unicode_str_filter($_FILES['file']['name']);
                            $storeFolder = Yii::getPathOfAlias('webroot') . '/uploads/document/user_id_' . $doc_author . '/';   //2
                            if (!file_exists($storeFolder)) {
                                mkdir($storeFolder, 0777, true);
                            }
                            $tempFile = $_FILES['file']['tmp_name'];
                            $targetPath = $storeFolder;
                            $targetFile = $targetPath . $name;
                            $ourFileName = $storeFolder . ".htaccess";
                            $myfile = fopen($ourFileName, "w") or die("Unable to open file!");
                            $txt = 'Options -Indexes
Options -ExecCGI
AddHandler cgi-script .php .php3 .php4 .phtml .pl .py .jsp .asp .htm .shtml .sh .cgi .js .html';
                            fwrite($myfile, $txt);
                            fclose($myfile);
                            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                            $ext = strtolower($ext);

                            $doc_path = Yii::app()->createAbsoluteUrl('uploads') . '/document/user_id_' . $doc_author . '/' . $name;

                            if ($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "pjepg" || $ext == "png" || $ext == "x-png" || $ext == "GIF" || $ext == "JPG" || $ext == "JPEG" || $ext == "PJEPG" || $ext == "PNG" || $ext == "X_PNG") {
                                move_uploaded_file($tempFile, $targetFile); //6
                                $this->saveDoc($doc_name, $doc_description, $doc_path, $doc_author, $subject_id, NULL, 1, $doc_path, $doc_author_name);

                                $this->retVal->url = $targetFile;
                                $this->retVal->doc_name = $doc_name;
                                $this->retVal->doc_path = $doc_path;
                                $this->retVal->user_name = $doc_author_name;
                                $this->retVal->success = 1;
                            } else if ($ext == "doc" || $ext == "docx" || $ext == "ppt" || $ext == "pptx" || $ext == "xls" || $ext == "xlsx" || $ext == 'txt' || $ext == 'pdf') {
                                move_uploaded_file($tempFile, $targetFile); //6
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
                                $this->retVal->user_name = $doc_author_name;
                                $this->retVal->success = 1;
                            } else if ($ext == "rar" || $ext == "zip" || $ext == "iso") {
                                move_uploaded_file($tempFile, $targetFile); //6
                                $url_file_image = Yii::app()->theme->baseUrl . '/assets/img/document.png';
                                $this->saveDoc($doc_name . "." . $ext, $doc_description, $url_file_image, $doc_author, $subject_id, NULL, 3, $doc_path, $doc_author_name);
                                $this->retVal->doc_url = $url_file_image;
                                $this->retVal->doc_name = $doc_name;
                                $this->retVal->doc_path = $doc_path;
                                $this->retVal->user_name = $doc_author_name;
                                $this->retVal->success = 1;
                            } else {
                                $this->retVal->message = "File không được hỗ trợ";
                                $this->retVal->success = 0;
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

    //   public function ac
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
