<?php

/**
 * This is the model class for table "tbl_doc".
 *
 * The followings are the available columns in table 'tbl_doc':
 * @property integer $doc_id
 * @property string $doc_url
 * @property string $doc_name
 * @property string $doc_scribd_id
 * @property string $doc_description
 * @property string $doc_title
 * @property string $doc_status
 * @property string $doc_author
 * @property integer $doc_type
 * @property string $doc_path
 * @property integer $subject_dept
 * @property integer $subject_type
 * @property integer $subject_faculty
 * @property string $doc_author_name
 * @property string $doc_publisher
 * @property integer $subject_general_faculty_id
 */
class Doc extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    var $doc_dept_name, $doc_subject_name, $subject_doc;
    var $doc_path_file = null;

    public function tableName() {
        return 'tbl_doc';
    }

    public function modelFileMap() {
        return array(
            "doc_path_file" => "doc_path"
        );
    }

    protected function beforeValidate() {
        if (!parent::beforeValidate())
            return false;
        if ($this->scenario == "fromAdmin") {
            if ($this->doc_path_file == NULL) {
                $this->addError("doc_path", "doc_path is required");
                return false;
            }
            if (!$this->doc_path_file->checkExt(array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png'))) {
                return FALSE;
            }
            $api_key = "24cxjtv3vw69wu5p7pqd9";
            $secret = "sec-b2rlvg8kxwwpkz9fo3i02mo9vo";
            $scribd = new Scribd($api_key, $secret);
            $ext = $this->doc_path_file->getExtension();
            $name = StringHelper::unicode_str_filter($this->doc_path_file->name);
            $storeFolder = Yii::getPathOfAlias('webroot') . '/uploads/document/user_id_' . $this->doc_author;   //2
            $targetPath = $storeFolder;  //4
            $doc_path = Yii::app()->createAbsoluteUrl('uploads') . '/document/user_id_' . $this->doc_author . '/' . $name;

            $targetFile = $targetPath . "/" . $name;  //5
            // move_uploaded_file($tempFile, $targetFile); //6
            if (!file_exists($storeFolder)) {
                mkdir($storeFolder, 0777, true);
            }
            if ($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "pjepg" || $ext == "png" || $ext == "x-png" || $ext == "GIF" || $ext == "JPG" || $ext == "JPEG" || $ext == "PJEPG" || $ext == "PNG" || $ext == "X_PNG") {
                $this->doc_path_file->save($targetPath, $name);
                $this->doc_url = $targetFile;
                $this->doc_path = $doc_path;
                $this->doc_type = 1;
            } else if ($ext == "doc" || $ext == "docx" || $ext == "ppt" || $ext == "pptx" || $ext == "xls" || $ext == "xlsx" || $ext == 'txt' || $ext == 'pdf') {
                $this->doc_path_file->save($targetPath, $name);
                $upload_scribd = @$scribd->upload($targetFile);
//                var_dump($targetFile);
//                die();
                $thumbnail_info = array('doc_id' => $upload_scribd["doc_id"],
                    'method' => NULL,
                    'session_key' => NULL,
                    'my_user_id' => NULL,
                    'width' => '220',
                    'height' => '250');
                $get_thumbnail = @$scribd->postRequest('thumbnail.get', $thumbnail_info);
                $this->doc_scribd_id = @$upload_scribd["doc_id"];
                $this->doc_url = @$get_thumbnail["thumbnail_url"];
                $this->doc_path = $doc_path;
                $this->doc_type = 2;
            } else {
                $this->doc_path_file->save($targetPath, $name);
                $url_file_image = Yii::app()->theme->baseUrl . '/assets/img/document.png';
                $this->doc_url = $url_file_image;
                $this->doc_path = $doc_path;               
                $this->doc_type = 3;
            }
        }

        return TRUE;
    }

    protected function afterSave() {
        parent::afterSave();
        if ($this->getIsNewRecord() && $this->scenario == "fromAdmin") {
            $sub_doc = new SubjectDoc;
            $sub_doc->subject_id = $this->subject_doc;
            $sub_doc->doc_id = $this->doc_id;
           
            $sub_doc->save(FALSE);
        }
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('doc_type, subject_dept, subject_type, subject_faculty, subject_general_faculty_id', 'numerical', 'integerOnly' => true),
            array('doc_url, doc_name, doc_scribd_id, doc_description, doc_title, doc_status', 'length', 'max' => 200),
            array('doc_author', 'length', 'max' => 30),
            array('doc_path', 'length', 'max' => 500),
            array('doc_publisher', 'length', 'max' => 255),
            array('doc_author_name', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('doc_id, doc_url, doc_name, doc_scribd_id, doc_description, doc_title, doc_status, doc_author, doc_type, doc_path, subject_dept, subject_type, subject_faculty, doc_author_name, doc_publisher, subject_general_faculty_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'docs' => array(self::BELONGS_TO, 'SubjectDoc', 'doc_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'doc_id' => 'Doc',
            'doc_url' => 'Doc Url',
            'doc_name' => 'Doc Name',
            'doc_scribd_id' => 'Doc Scribd',
            'doc_description' => 'Doc Description',
            'doc_title' => 'Doc Title',
            'doc_status' => 'Doc Status',
            'doc_author' => 'Doc Author',
            'doc_type' => 'Doc Type',
            'doc_path' => 'Doc Path',
            'subject_dept' => 'Subject Dept',
            'subject_type' => 'Subject Type',
            'subject_faculty' => 'Subject Faculty',
            'doc_author_name' => 'Doc Author Name',
            'doc_publisher' => 'Doc Publisher',
            'subject_general_faculty_id' => 'Subject General Faculty',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('doc_id', $this->doc_id);
        $criteria->compare('doc_url', $this->doc_url, true);
        $criteria->compare('doc_name', $this->doc_name, true);
        $criteria->compare('doc_scribd_id', $this->doc_scribd_id, true);
        $criteria->compare('doc_description', $this->doc_description, true);
        $criteria->compare('doc_title', $this->doc_title, true);
        $criteria->compare('doc_status', $this->doc_status, true);
        $criteria->compare('doc_author', $this->doc_author, true);
        $criteria->compare('doc_type', $this->doc_type);
        $criteria->compare('doc_path', $this->doc_path, true);
        $criteria->compare('subject_dept', $this->subject_dept);
        $criteria->compare('subject_type', $this->subject_type);
        $criteria->compare('subject_faculty', $this->subject_faculty);
        $criteria->compare('doc_author_name', $this->doc_author_name, true);
        $criteria->compare('doc_publisher', $this->doc_publisher, true);
        $criteria->compare('subject_general_faculty_id', $this->subject_general_faculty_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Doc the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
