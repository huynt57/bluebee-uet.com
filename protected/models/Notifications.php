<?php

/**
 * This is the model class for table "notifications".
 *
 * The followings are the available columns in table 'notifications':
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property string $object_type
 * @property integer $object_id
 * @property integer $possessive
 * @property integer $from_user_id
 * @property integer $clicked
 * @property integer $relevant_id
 * @property integer $relevant_object
 * @property string $app
 * @property integer $is_active
 */
class Notifications extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, object_id, possessive, from_user_id, clicked, relevant_id, relevant_object, is_active', 'numerical', 'integerOnly'=>true),
			array('action, object_type, app', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, action, object_type, object_id, possessive, from_user_id, clicked, relevant_id, relevant_object, app, is_active', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'action' => 'Action',
			'object_type' => 'Object Type',
			'object_id' => 'Object',
			'possessive' => 'Possessive',
			'from_user_id' => 'From User',
			'clicked' => 'Clicked',
			'relevant_id' => 'Relevant',
			'relevant_object' => 'Relevant Object',
			'app' => 'App',
			'is_active' => 'Is Active',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('object_type',$this->object_type,true);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('possessive',$this->possessive);
		$criteria->compare('from_user_id',$this->from_user_id);
		$criteria->compare('clicked',$this->clicked);
		$criteria->compare('relevant_id',$this->relevant_id);
		$criteria->compare('relevant_object',$this->relevant_object);
		$criteria->compare('app',$this->app,true);
		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notifications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
