<?php

/**
 * This is the model class for table "tbl_teacher_faculty_position".
 *
 * The followings are the available columns in table 'tbl_teacher_faculty_position':
 * @property integer $id
 * @property integer $teacher_id
 * @property string $teacher_name
 * @property integer $faculty_id
 * @property string $teacher_position
 */
class TeacherFacultyPosition extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_teacher_faculty_position';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teacher_id, faculty_id', 'numerical', 'integerOnly'=>true),
			array('teacher_name, teacher_position', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, teacher_id, teacher_name, faculty_id, teacher_position', 'safe', 'on'=>'search'),
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
			'teacher_id' => 'Teacher',
			'teacher_name' => 'Teacher Name',
			'faculty_id' => 'Faculty',
			'teacher_position' => 'Teacher Position',
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
		$criteria->compare('teacher_id',$this->teacher_id);
		$criteria->compare('teacher_name',$this->teacher_name,true);
		$criteria->compare('faculty_id',$this->faculty_id);
		$criteria->compare('teacher_position',$this->teacher_position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TeacherFacultyPosition the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
