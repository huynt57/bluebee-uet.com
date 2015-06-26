<?php

class WebUser extends CWebUser{

	public function __get($name)
    {
        if ($this->hasState('__userInfo')) {
            $user=$this->getState('__userInfo',array());
            if (isset($user[$name])) {
                return $user[$name];
            }
        }
 
        return parent::__get($name);
    }
 
    public function login($identity, $duration=0) {
        $this->setState('__userInfo', $identity->getUser());
        parent::login($identity, $duration);
    }
 
    /* 
    * Required to checkAccess function
    * Yii::app()->user->checkAccess('operation')
    */
    public function getId()
    {
        return $this->id;
    }

	public function isAdmin(){
        return $this->type == User::TYPE_ADMIN;
    }

    public function isLocal(){
        return $this->type == User::TYPE_LOCAL;
    }

    public function isSell(){
        return $this->type == User::TYPE_SELL;
    }

    public function isCustomer(){
        return $this->type == User::TYPE_CUSTOMER;
    }

    public function isNotLoggedIn(){
        return $this->isGuest;
    }

    public function checkUserPermission($type){
        if($this->type==$type)
            return true;
        $module = "";
        switch($this->type){
            case User::TYPE_ADMIN:
                $module = "admin";
                break;
            case User::TYPE_LOCAL:
                $module = "local";
                break;
            case User::TYPE_SELL:
                $module = "sell";
                break;
            case User::TYPE_CUSTOMER:
                $module = "customer";
                break;
            default:
                $module = "site";
                break;
        }
        $module = "/" . $module;
        Yii::app()->controller->redirect($module);
    }
}