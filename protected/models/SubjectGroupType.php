<?php

/**
 * This is the model class for table "tbl_subject_group_type".
 *
 * The followings are the available columns in table 'tbl_subject_group_type':
 * @property integer $subject_type_id
 * @property string $subject_group_type
 * @property integer $active
 * @property string $detail
 * @property integer $subject_group
 */
class SubjectGroupType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_subject_group_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active, subject_group', 'numerical', 'integerOnly'=>true),
			array('subject_group_type', 'length', 'max'=>255),
			array('detail', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('subject_type_id, subject_group_type, active, detail, subject_group', 'safe', 'on'=>'search'),
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
			'subject_type_id' => 'Subject Type',
			'subject_group_type' => 'Subject Group Type',
			'active' => 'Active',
			'detail' => 'Detail',
			'subject_group' => 'Subject Group',
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

		$criteria->compare('subject_type_id',$this->subject_type_id);
		$criteria->compare('subject_group_type',$this->subject_group_type,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('subject_group',$this->subject_group);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubjectGroupType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
