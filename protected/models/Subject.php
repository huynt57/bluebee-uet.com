<?php

/**
 * This is the model class for table "tbl_subject".
 *
 * The followings are the available columns in table 'tbl_subject':
 * @property integer $subject_id
 * @property string $subject_name
 * @property string $subject_code
 * @property string $subject_active
 * @property string $subject_university
 * @property integer $subject_type
 * @property integer $subject_year
 * @property integer $subject_credits
 * @property string $subject_credit_hour
 * @property string $subject_requirement
 * @property string $subject_target
 * @property string $subject_info
 * @property string $subject_test
 * @property integer $subject_faculty
 * @property integer $subject_dept
 * @property string $subject_content
 * @property integer $subject_general_faculty_id
 */
class Subject extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_subject';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject_type, subject_year, subject_credits, subject_faculty, subject_dept, subject_general_faculty_id', 'numerical', 'integerOnly'=>true),
			array('subject_name, subject_credit_hour', 'length', 'max'=>100),
			array('subject_code, subject_active, subject_university', 'length', 'max'=>45),
			array('subject_requirement', 'length', 'max'=>500),
			array('subject_target, subject_info, subject_test', 'length', 'max'=>1000),
			array('subject_content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('subject_id, subject_name, subject_code, subject_active, subject_university, subject_type, subject_year, subject_credits, subject_credit_hour, subject_requirement, subject_target, subject_info, subject_test, subject_faculty, subject_dept, subject_content, subject_general_faculty_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'subject_doc' => array (self::BELONGS_TO, 'SubjectDoc', array('subject_id'=>'subject_id')),
                    'subject_teacher' => array(self::BELONGS_TO, 'SubjectTeacher', array('subject_id'=>'subject_id'))
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subject_id' => 'Subject',
			'subject_name' => 'Subject Name',
			'subject_code' => 'Subject Code',
			'subject_active' => 'Subject Active',
			'subject_university' => 'Subject University',
			'subject_type' => 'Subject Type',
			'subject_year' => 'Subject Year',
			'subject_credits' => 'Subject Credits',
			'subject_credit_hour' => 'Subject Credit Hour',
			'subject_requirement' => 'Subject Requirement',
			'subject_target' => 'Subject Target',
			'subject_info' => 'Subject Info',
			'subject_test' => 'Subject Test',
			'subject_faculty' => 'Subject Faculty',
			'subject_dept' => 'Subject Dept',
			'subject_content' => 'Subject Content',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('subject_id',$this->subject_id);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('subject_code',$this->subject_code,true);
		$criteria->compare('subject_active',$this->subject_active,true);
		$criteria->compare('subject_university',$this->subject_university,true);
		$criteria->compare('subject_type',$this->subject_type);
		$criteria->compare('subject_year',$this->subject_year);
		$criteria->compare('subject_credits',$this->subject_credits);
		$criteria->compare('subject_credit_hour',$this->subject_credit_hour,true);
		$criteria->compare('subject_requirement',$this->subject_requirement,true);
		$criteria->compare('subject_target',$this->subject_target,true);
		$criteria->compare('subject_info',$this->subject_info,true);
		$criteria->compare('subject_test',$this->subject_test,true);
		$criteria->compare('subject_faculty',$this->subject_faculty);
		$criteria->compare('subject_dept',$this->subject_dept);
		$criteria->compare('subject_content',$this->subject_content,true);
		$criteria->compare('subject_general_faculty_id',$this->subject_general_faculty_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subject the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
