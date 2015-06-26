<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $user_id
 * @property string $user_id_fb
 * @property string $username
 * @property string $password
 * @property string $user_real_name
 * @property string $user_avatar
 * @property string $user_cover
 * @property string $user_student_code
 * @property integer $user_university
 * @property string $user_gender
 * @property string $user_dob
 * @property string $user_hometown
 * @property string $user_phone
 * @property string $user_description
 * @property integer $user_faculty
 * @property integer $user_class
 * @property integer $user_active
 * @property integer $user_status
 * @property integer $user_group
 * @property string $user_token
 * @property string $user_activator
 * @property string $user_qoutes
 * @property string $user_date_attend
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_university, user_faculty, user_class, user_active, user_status, user_group', 'numerical', 'integerOnly'=>true),
			array('user_id_fb, user_avatar, user_cover, user_hometown, user_description, user_token, user_activator, user_date_attend', 'length', 'max'=>200),
			array('username, password, user_real_name, user_student_code, user_gender, user_dob, user_phone', 'length', 'max'=>45),
			array('user_qoutes', 'length', 'max'=>400),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_id_fb, username, password, user_real_name, user_avatar, user_cover, user_student_code, user_university, user_gender, user_dob, user_hometown, user_phone, user_description, user_faculty, user_class, user_active, user_status, user_group, user_token, user_activator, user_qoutes, user_date_attend', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'user_id_fb' => 'User Id Fb',
			'username' => 'Username',
			'password' => 'Password',
			'user_real_name' => 'User Real Name',
			'user_avatar' => 'User Avatar',
			'user_cover' => 'User Cover',
			'user_student_code' => 'User Student Code',
			'user_university' => 'User University',
			'user_gender' => 'User Gender',
			'user_dob' => 'User Dob',
			'user_hometown' => 'User Hometown',
			'user_phone' => 'User Phone',
			'user_description' => 'User Description',
			'user_faculty' => 'User Faculty',
			'user_class' => 'User Class',
			'user_active' => 'User Active',
			'user_status' => 'User Status',
			'user_group' => 'User Group',
			'user_token' => 'User Token',
			'user_activator' => 'User Activator',
			'user_qoutes' => 'User Qoutes',
			'user_date_attend' => 'User Date Attend',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_id_fb',$this->user_id_fb,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('user_real_name',$this->user_real_name,true);
		$criteria->compare('user_avatar',$this->user_avatar,true);
		$criteria->compare('user_cover',$this->user_cover,true);
		$criteria->compare('user_student_code',$this->user_student_code,true);
		$criteria->compare('user_university',$this->user_university);
		$criteria->compare('user_gender',$this->user_gender,true);
		$criteria->compare('user_dob',$this->user_dob,true);
		$criteria->compare('user_hometown',$this->user_hometown,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_description',$this->user_description,true);
		$criteria->compare('user_faculty',$this->user_faculty);
		$criteria->compare('user_class',$this->user_class);
		$criteria->compare('user_active',$this->user_active);
		$criteria->compare('user_status',$this->user_status);
		$criteria->compare('user_group',$this->user_group);
		$criteria->compare('user_token',$this->user_token,true);
		$criteria->compare('user_activator',$this->user_activator,true);
		$criteria->compare('user_qoutes',$this->user_qoutes,true);
		$criteria->compare('user_date_attend',$this->user_date_attend,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
