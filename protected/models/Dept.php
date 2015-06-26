<?php

/**
 * This is the model class for table "tbl_dept".
 *
 * The followings are the available columns in table 'tbl_dept':
 * @property integer $dept_id
 * @property string $dept_name
 * @property integer $dept_active
 * @property integer $dept_faculty
 * @property string $dept_target
 * @property string $dept_knowleadge
 * @property string $dept_behavior
 * @property string $dept_out_standard
 * @property string $dept_contact
 * @property string $dept_in_standart
 * @property string $dept_language
 * @property integer $dept_credits
 * @property string $dept_code
 * @property string $dept_link_download
 * @property string $dept_skill
 */
class Dept extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    var $dept_faculty_name;
	public function tableName()
	{
		return 'tbl_dept';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dept_active, dept_faculty, dept_credits', 'numerical', 'integerOnly'=>true),
			array('dept_name', 'length', 'max'=>100),
			array('dept_code', 'length', 'max'=>255),
			array('dept_link_download', 'length', 'max'=>500),
			array('dept_target, dept_knowleadge, dept_behavior, dept_out_standard, dept_contact, dept_in_standart, dept_language, dept_skill', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dept_id, dept_name, dept_active, dept_faculty, dept_target, dept_knowleadge, dept_behavior, dept_out_standard, dept_contact, dept_in_standart, dept_language, dept_credits, dept_code, dept_link_download, dept_skill', 'safe', 'on'=>'search'),
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
			'dept_id' => 'Dept',
			'dept_name' => 'Dept Name',
			'dept_active' => 'Dept Active',
			'dept_faculty' => 'Dept Faculty',
			'dept_target' => 'Dept Target',
			'dept_knowleadge' => 'Dept Knowleadge',
			'dept_behavior' => 'Dept Behavior',
			'dept_out_standard' => 'Dept Out Standard',
			'dept_contact' => 'Dept Contact',
			'dept_in_standart' => 'Dept In Standart',
			'dept_language' => 'Dept Language',
			'dept_credits' => 'Dept Credits',
			'dept_code' => 'Dept Code',
			'dept_link_download' => 'Dept Link Download',
			'dept_skill' => 'Dept Skill',
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

		$criteria->compare('dept_id',$this->dept_id);
		$criteria->compare('dept_name',$this->dept_name,true);
		$criteria->compare('dept_active',$this->dept_active);
		$criteria->compare('dept_faculty',$this->dept_faculty);
		$criteria->compare('dept_target',$this->dept_target,true);
		$criteria->compare('dept_knowleadge',$this->dept_knowleadge,true);
		$criteria->compare('dept_behavior',$this->dept_behavior,true);
		$criteria->compare('dept_out_standard',$this->dept_out_standard,true);
		$criteria->compare('dept_contact',$this->dept_contact,true);
		$criteria->compare('dept_in_standart',$this->dept_in_standart,true);
		$criteria->compare('dept_language',$this->dept_language,true);
		$criteria->compare('dept_credits',$this->dept_credits);
		$criteria->compare('dept_code',$this->dept_code,true);
		$criteria->compare('dept_link_download',$this->dept_link_download,true);
		$criteria->compare('dept_skill',$this->dept_skill,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dept the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
