<?php

/**
 * This is the model class for table "tbl_university".
 *
 * The followings are the available columns in table 'tbl_university':
 * @property integer $university_id
 * @property string $university_name
 * @property string $university_location
 * @property string $university_code
 * @property string $university_web
 * @property string $university_description
 * @property string $university_active
 */
class University extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_university';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('university_name, university_location, university_code, university_web, university_description', 'length', 'max'=>200),
			array('university_active', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('university_id, university_name, university_location, university_code, university_web, university_description, university_active', 'safe', 'on'=>'search'),
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
			'university_id' => 'University',
			'university_name' => 'University Name',
			'university_location' => 'University Location',
			'university_code' => 'University Code',
			'university_web' => 'University Web',
			'university_description' => 'University Description',
			'university_active' => 'University Active',
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

		$criteria->compare('university_id',$this->university_id);
		$criteria->compare('university_name',$this->university_name,true);
		$criteria->compare('university_location',$this->university_location,true);
		$criteria->compare('university_code',$this->university_code,true);
		$criteria->compare('university_web',$this->university_web,true);
		$criteria->compare('university_description',$this->university_description,true);
		$criteria->compare('university_active',$this->university_active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return University the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
