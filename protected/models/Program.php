<?php

/**
 * This is the model class for table "tbl_program".
 *
 * The followings are the available columns in table 'tbl_program':
 * @property integer $program_id
 * @property string $program_name
 * @property integer $program_credits
 * @property integer $program_year
 * @property integer $program_active
 * @property string $program_code
 */
class Program extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_program';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('program_credits, program_year, program_active', 'numerical', 'integerOnly'=>true),
			array('program_name, program_code', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('program_id, program_name, program_credits, program_year, program_active, program_code', 'safe', 'on'=>'search'),
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
			'program_id' => 'Program',
			'program_name' => 'Program Name',
			'program_credits' => 'Program Credits',
			'program_year' => 'Program Year',
			'program_active' => 'Program Active',
			'program_code' => 'Program Code',
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

		$criteria->compare('program_id',$this->program_id);
		$criteria->compare('program_name',$this->program_name,true);
		$criteria->compare('program_credits',$this->program_credits);
		$criteria->compare('program_year',$this->program_year);
		$criteria->compare('program_active',$this->program_active);
		$criteria->compare('program_code',$this->program_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Program the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
