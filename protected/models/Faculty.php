<?php

/**
 * This is the model class for table "tbl_faculty".
 *
 * The followings are the available columns in table 'tbl_faculty':
 * @property integer $faculty_id
 * @property integer $faculty_university
 * @property string $faculty_name
 * @property string $faculty_code
 * @property integer $faculty_active
 * @property string $faculty_research
 * @property string $faculty_lab
 */
class Faculty extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_faculty';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faculty_university, faculty_active', 'numerical', 'integerOnly'=>true),
			array('faculty_name, faculty_code', 'length', 'max'=>200),
			array('faculty_research, faculty_lab', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('faculty_id, faculty_university, faculty_name, faculty_code, faculty_active, faculty_research, faculty_lab', 'safe', 'on'=>'search'),
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
			'faculty_id' => 'Faculty',
			'faculty_university' => 'Faculty University',
			'faculty_name' => 'Faculty Name',
			'faculty_code' => 'Faculty Code',
			'faculty_active' => 'Faculty Active',
			'faculty_research' => 'Faculty Research',
			'faculty_lab' => 'Faculty Lab',
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

		$criteria->compare('faculty_id',$this->faculty_id);
		$criteria->compare('faculty_university',$this->faculty_university);
		$criteria->compare('faculty_name',$this->faculty_name,true);
		$criteria->compare('faculty_code',$this->faculty_code,true);
		$criteria->compare('faculty_active',$this->faculty_active);
		$criteria->compare('faculty_research',$this->faculty_research,true);
		$criteria->compare('faculty_lab',$this->faculty_lab,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Faculty the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
