<?php

/**
 * This is the model class for table "tbl_comment".
 *
 * The followings are the available columns in table 'tbl_comment':
 * @property integer $comment_id
 * @property integer $comment_post_id
 * @property integer $comment_group_id
 * @property integer $comment_class_id
 * @property integer $comment_author_id
 * @property string $comment_content
 * @property string $comment_time
 * @property integer $comment_active
 * @property integer $comment_rate
 */
class Comment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment_post_id, comment_group_id, comment_class_id, comment_author_id, comment_active, comment_rate', 'numerical', 'integerOnly'=>true),
			array('comment_content', 'length', 'max'=>300),
			array('comment_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('comment_id, comment_post_id, comment_group_id, comment_class_id, comment_author_id, comment_content, comment_time, comment_active, comment_rate', 'safe', 'on'=>'search'),
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
			'comment_id' => 'Comment',
			'comment_post_id' => 'Comment Post',
			'comment_group_id' => 'Comment Group',
			'comment_class_id' => 'Comment Class',
			'comment_author_id' => 'Comment Author',
			'comment_content' => 'Comment Content',
			'comment_time' => 'Comment Time',
			'comment_active' => 'Comment Active',
			'comment_rate' => 'Comment Rate',
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

		$criteria->compare('comment_id',$this->comment_id);
		$criteria->compare('comment_post_id',$this->comment_post_id);
		$criteria->compare('comment_group_id',$this->comment_group_id);
		$criteria->compare('comment_class_id',$this->comment_class_id);
		$criteria->compare('comment_author_id',$this->comment_author_id);
		$criteria->compare('comment_content',$this->comment_content,true);
		$criteria->compare('comment_time',$this->comment_time,true);
		$criteria->compare('comment_active',$this->comment_active);
		$criteria->compare('comment_rate',$this->comment_rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
