<?php

/**
 * This is the model class for table "tbl_lesson".
 *
 * The followings are the available columns in table 'tbl_lesson':
 * @property integer $lesson_id
 * @property integer $lesson_active
 * @property string $lesson_weeks
 * @property integer $lesson_subject
 * @property string $lesson_name
 * @property string $lesson_info
 * @property string $lesson_doc
 */
class Lesson extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_lesson';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lesson_active, lesson_subject', 'numerical', 'integerOnly'=>true),
			array('lesson_weeks', 'length', 'max'=>100),
			array('lesson_name', 'length', 'max'=>300),
			array('lesson_info', 'length', 'max'=>500),
			array('lesson_doc', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lesson_id, lesson_active, lesson_weeks, lesson_subject, lesson_name, lesson_info, lesson_doc', 'safe', 'on'=>'search'),
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
			'lesson_id' => 'Lesson',
			'lesson_active' => 'Lesson Active',
			'lesson_weeks' => 'Lesson Weeks',
			'lesson_subject' => 'Lesson Subject',
			'lesson_name' => 'Lesson Name',
			'lesson_info' => 'Lesson Info',
			'lesson_doc' => 'Lesson Doc',
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

		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('lesson_active',$this->lesson_active);
		$criteria->compare('lesson_weeks',$this->lesson_weeks,true);
		$criteria->compare('lesson_subject',$this->lesson_subject);
		$criteria->compare('lesson_name',$this->lesson_name,true);
		$criteria->compare('lesson_info',$this->lesson_info,true);
		$criteria->compare('lesson_doc',$this->lesson_doc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lesson the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
