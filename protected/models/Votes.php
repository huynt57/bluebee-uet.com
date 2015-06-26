<?php

/**
 * This is the model class for table "votes".
 *
 * The followings are the available columns in table 'votes':
 * @property integer $id
 * @property integer $user_id
 * @property string $vote_type
 * @property integer $teacher_id
 * @property string $object_type
 * @property integer $rating_score
 */
class Votes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'votes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, teacher_id, rating_score', 'numerical', 'integerOnly'=>true),
			array('vote_type, object_type', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, vote_type, teacher_id, object_type, rating_score', 'safe', 'on'=>'search'),
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
			'vote_type' => 'Vote Type',
			'teacher_id' => 'Teacher',
			'object_type' => 'Object Type',
			'rating_score' => 'Rating Score',
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
		$criteria->compare('vote_type',$this->vote_type,true);
		$criteria->compare('teacher_id',$this->teacher_id);
		$criteria->compare('object_type',$this->object_type,true);
		$criteria->compare('rating_score',$this->rating_score);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Votes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
