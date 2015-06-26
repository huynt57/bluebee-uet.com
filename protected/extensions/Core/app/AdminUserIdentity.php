<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminUserIdentity extends CUserIdentity
{
    const ERROR_USER_NOT_ACTIVE = "ERROR_USER_NOT_ACTIVE";
	public $_id;
    public function authenticate()
    {
        $record=User::model()->findByAttributes(array('email'=>$this->username));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!$record->validatePassword($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else if($record->is_active==0)
        {
            $this->_id = $record->id;
            $this->errorCode = self::ERROR_USER_NOT_ACTIVE;
        }
        else
        {
            $this->_id=$record->id;
            $this->setState('id', $record->id);
            $this->setState('name', $record->username);
            $this->setState("email",$record->email);
            $this->setState("isAdmin",1);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}