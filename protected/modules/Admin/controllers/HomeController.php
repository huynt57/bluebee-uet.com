<?php

class HomeController extends AdminTableController {

    var $pages = array(
        "user" => array(
            "title" => "User manager"
        ),
        "document" => array(
            "title" => "Document manager"
        ),
        "faculty" => array(
            "title" => "Faculty manager"
        ),
        "dept" => array(
            "title" => "Department manager"
        ),
        "subject" => array(
            "title" => "Subject manager"
        ),
        "teacher" => array(
            "title" => "Teacher manager"
        ),
        "subjecttype" => array(
            "title" => "Subject Type manager"
        ),
        "subjectgrouptype" => array(
            "title" => "Subject Group Type manager"
        ),
        "subjectdoc" => array(
            "title" => "Subject - Doc manager"
        ),
        "subjectteacher" => array(
            "title" => "Subject - Teacher manager"
        ),
        "teacherfacultypos" => array(
            "title" => "Teacher Position in Faculty"
        ),
        "lesson" => array(
            "title" => "Lesson manager"
        ),
        "lessondoc" => array(
            "title" => "Lesson - Doc manager"
        ),
        "lessonvideo" => array(
            "title" => "Lesson - Video manager"
        ),
    );

//    public function beforeAction($action) {
//        if (Yii::app()->user->isGuest && $action=="login") {
//            $this->redirect(Yii::app()->createUrl('/admin/home/login'));
//            return false;
//        }
//        return parent::beforeAction($action);
//    }

    public function actionIndex() {
        $this->render('index');
    }

    protected function getTheme() {
        return "madmin";
    }

    protected function getBrandName() {
        return "Bluebee Admin";
    }

    protected function getLoginUrl() {
        return $this->md("home/login");
    }

    protected function getLogoutUrl() {
        return $this->md("home/logout");
    }

    protected function hasLoggedIn() {
        $user = Yii::app()->user;
        if (Yii::app()->session["admin_id"] != "")
            return true;
        return false;
    }

    protected function getActionLogin() {
        return "login";
    }

    protected function getActionLogout() {
        return "logout";
    }
    
    protected function getUsername() {
        return "Admin";
    }

    protected function getControllerLogin() {
        return "home";
    }

    public function actionLogin() {
        $this->layout = "login_layout";
        $request = Yii::app()->request;
        if ($request->isPostRequest && isset($_POST)) {
            try {
                $admin_name = Yii::app()->request->getPost('admin_name');
                $admin_password = Yii::app()->request->getPost('admin_password');
                $user = Admin::model()->findByAttributes(array('admin_name' => $admin_name));
                if ($user) {

                    //user existed, check password
                    if ($user->admin_password == md5($admin_password)) {
                        Yii::app()->session['admin_id'] = $user->admin_id;
                        $this->redirect($this->md('home/user'));
                    } else {
                        //wrong device token
//                        echo "đm lỗi2";
//                        die();
                        $this->redirect('login');
                    }
                    // }
                } else {
                    //user not existed
//                    echo "đm lỗi3";
//                    die();
                    $this->redirect('login');
                }
            } catch (exception $e) {

                echo ($e->getMessage());
            }
        }
        $this->render('login/index');
    }

    public function actionLogout() {
        Yii::app()->session['admin_id'] = "";
        $this->redirect('login');
    }

    protected function getFileLocation() {
        return __FILE__;
    }

    public function actionUser() {
        $this->setCurrentPage("user");
        $this->handleTable("user");
    }

    public function actionDocument() {
        $this->setCurrentPage("document");
        $this->handleTable("document");
    }

    public function actionFaculty() {
        $this->setCurrentPage("faculty");
        $this->handleTable("faculty");
    }

    public function actionDept() {
        $this->setCurrentPage("dept");
        $this->handleTable("dept");
    }

    public function actionSubjectType() {
        $this->setCurrentPage("subjecttype");
        $this->handleTable("subjecttype");
    }

    public function actionSubject() {
        $this->setCurrentPage("subject");
        $this->handleTable("subject");
    }

    public function actionSubjectGroupType() {
        $this->setCurrentPage("subjectgrouptype");
        $this->handleTable("subjectgrouptype");
    }

    public function actionSubjectDoc() {
        $this->setCurrentPage("subjectdoc");
        $this->handleTable("subjectdoc");
    }

    public function actionSubjectTeacher() {
        $this->setCurrentPage("subjectteacher");
        $this->handleTable("subjectteacher");
    }

    public function actionTeacherFacultyPos() {
        $this->setCurrentPage("teacherfacultypos");
        $this->handleTable("teacherfacultypos");
    }

    public function actionLesson() {
        $this->setCurrentPage("lesson");
        $this->handleTable("lesson");
    }

    public function actionLessonDoc() {
        $this->setCurrentPage("lessondoc");
        $this->handleTable("lessondoc");
    }

    public function actionLessonVideo() {
        $this->setCurrentPage("lessonvideo");
        $this->handleTable("lessonvideo");
    }

    public function actionTeacher() {
        $this->setCurrentPage("teacher");
        $this->handleTable("teacher");
    }

}
