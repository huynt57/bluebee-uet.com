<?php

/**
 * This is the model class for table "tbl_subject_group".
 *
 * The followings are the available columns in table 'tbl_subject_group':
 * @property integer $id
 * @property integer $subject_type_id
 * @property integer $faculty_id
 * @property integer $dept_id
 * @property string $subject_group_name
 * @property string $subject_group_info
 */
class SubjectGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_subject_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject_type_id, faculty_id, dept_id', 'numerical', 'integerOnly'=>true),
			array('subject_group_name', 'length', 'max'=>255),
			array('subject_group_info', 'length', 'max'=>10000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, subject_type_id, faculty_id, dept_id, subject_group_name, subject_group_info', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subject_type_id' => 'Subject Type',
			'faculty_id' => 'Faculty',
			'dept_id' => 'Dept',
			'subject_group_name' => 'Subject Group Name',
			'subject_group_info' => 'Subject Group Info',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('subject_type_id',$this->subject_type_id);
		$criteria->compare('faculty_id',$this->faculty_id);
		$criteria->compare('dept_id',$this->dept_id);
		$criteria->compare('subject_group_name',$this->subject_group_name,true);
		$criteria->compare('subject_group_info',$this->subject_group_info,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubjectGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
