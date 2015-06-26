<?php

abstract class AdminTableController extends CoreController
{
	var $title = "Admin Panel";
	var $table = null;
	var $pages = array();
	var $currentPage = "";

	var $tableDefault = array(
		"actions" => array(
			"_view" => "*",
			"_edit" => false,
			"_delete" => true,
			"_new" => false,
			"search" => true,
			"search_advanced" => false,
			"_link" => false,
			"_customButtons" => array(),
			"_checkbox" => false
		),
		"default" => array(
			"orderBy" => "id",
			"orderType" => "asc",
			"page" => 0,
			"per_page" => 10,
			"search" => "",
			"search_advanced" => ""
		),
		"type" => "table",
		"dragToReOrder" => false,
		"hasHtmlEditor" => false,
		"condition" => false,
		"join" => false,
		"with" => false,
		"limit_values" => array(10,20,30,40),
		"model" => null,
		"primary" => "id",
		"formUpload" => false,
		"itemLabel" => "Item",
		"additionalFiles" => array(
			"beginDocument" => null,
			"beforeTable" => null,
			"afterTable" => null,
			"endDocument" => null,
			"rightOfTitle" => null
		),
		"confirmDeleteMessage" => "Are you sure you want to delete this item? - It cannot be undone",
		"deleteCompletedly" => true,
		"updateScenario" => "update",
		"insertScenario" => "insert",
		"editType" => "popup", // page
		"viewType" => "popup", // page
		"createType" => "popup", // page
		"multiPages" => false,
		"hasAction" => true,
		"select" => false
	);

	var $tableAction = "";

	var $tableFieldDefault = array(
		"type" => "_text",
		"orderable" => true,
		"searchAdvancedType" => "_default",
		"selectType" => "t",
		"_list" => false
	);

	protected function getTable($name)
	{
		$table = include_once(dirname($this->getFileLocation()) . "/".$this->getFolderLocation()."/" . $name . ".php");
		$table = array_replace_recursive($this->tableDefault,$table);
		foreach($table["fields"] as $name => $field)
		{
			$table["fields"][$name] = array_merge($this->tableFieldDefault,$field);
			if(!isset($field["label"]))
				$table["fields"][$name]["label"] = ucwords($name);
			if(!in_array($this->tableAction, array(
				"data", "update", "delete", "insert", "reorder"
			))){
				// page
				$_list = $table["fields"][$name]["_list"];
				if(is_array($_list)){
					$list = array();
					$rows = $_list["src"]();
					foreach($rows as $row){
						$idField = $_list["primary"];
						$displayAttrField = $_list["displayAttr"];
						$list["".$row->$idField] = $row->$displayAttrField;
					}
					$table["fields"][$name]["list"] = $list;
				}
			}
		}
		$table["url"] = $this->md($this->id . "/" . $table["tableAlias"],false);
		if($table["actions"]["_view"]=="*")
		{
			$table["actions"]["_view"] = array();
			foreach($table["fields"] as $column => $field)
			{
				$table["actions"]["_view"][] = $column;
			}
		}

		$table["multiPages"] = ($table["editType"]=="page") || ($table["viewType"]=="page") || $table["createType"]=="page";

		return $table;
	}

	protected function handleTable($tableName)
	{
		$action = $this->input_get("action");
		$this->tableAction = $action;
		$table = $this->getTable($tableName);
		switch($action){
			case "data":
				$this->tableData($table);
				break;
			case "update":
				$this->tableUpdate($table);
				break;
			case "delete":
				$this->tableDelete($table);
				break;
			case "insert":
				$this->tableInsert($table);
				break;
			case "reorder":
				$this->tableOrder($table);
				break;
			default:
				$action = "page";
				$this->data["table"] = $table;
				$this->headerTitle = $table["title"];
				$this->renderViewTable();
				break;
		}
	}	

	public function setCurrentPage($page){
		$this->currentPage = $page;
	}

	protected function tableData($table){

		//$results = Invoice::model()->with(array("customer", "location"))->findAll(); print_r($results); die();

		$criteria = $this->criteriaFromRequest($table);
		$findObject = $table["model"]::model();
		//print_r($criteria); die();
		$rows = $findObject->findAll($criteria);
		$count = $findObject->count($criteria);
		$data = array();

		$selfGeneratedValueFields = array();
		foreach($table["fields"] as $fieldName => $field){
			if(isset($field["value"]))
			{
				$selfGeneratedValueFields[] = $fieldName;
			}
		}

		foreach($rows as $i => $row)
		{
			$item = array();
			foreach($table["fields"] as $fieldName => $field){
				if(isset($field["value"]))
				{
					continue;
				}
				$item[$fieldName] = $row->$fieldName;
			}
			foreach($selfGeneratedValueFields as $fieldName){
				$item[$fieldName] = $table["fields"][$fieldName]["value"]($row);
			}
			$data[] = $item;
		}
		//print_r($data); die();

		$this->returnSuccess(array(
			"data" => $data,
			"count" => $count
		));
	}

	protected function criteriaFromRequest($table)
	{
		// order, page, per_page, search, search_advanced
		$order = $this->input_get_post("order","id desc");
		$page = intval($this->input_get_post("page",0));
		$per_page = intval($this->input_get_post("per_page",10));
		$search = trim($this->input_get_post("search",""));
		$search_advanced = $this->input_get_post("search_advanced",0);
		//
		$criteria=new CDbCriteria();
		$criteria->together = true;

		if($table["condition"]){
			foreach($table["condition"] as $key => $val){
				if(is_numeric($key))
				{
					$criteria->addCondition($val);
					continue;
				}
				$criteria->compare($key,$val,false,"AND",false);
			}
		}

		if($search!="" && $table["actions"]["_search"])
		{
			$searchAttr = $table["actions"]["_search"];
			foreach($searchAttr as $i => $attr)
			{
				$field = $table["fields"][$attr];
				if($field["selectType"]=="alias"){
					$attr = $table["select"][$attr];
				} elseif(isset($field["src"])){
					$attr = $field["src"];
				} else {
					$attr = "t.".$attr;
				}
				$criteria->compare($attr,$search,true,"OR",true);
			}
		}
		if($search_advanced)
		{
			foreach($search_advanced as $attr => $val)
			{
				$field = $table["fields"][$attr];
				if($field["selectType"]=="alias"){
					$attr = $table["select"][$attr];
				} elseif(isset($field["src"])){
					$attr = $field["src"];
				} else {
					$attr = "t.".$attr;
				}
				switch($field["searchAdvancedType"]){
					case "_timestamp_range":
						// $val is an array
						if(@$val["from"])
							$criteria->compare($attr,">=" . strtotime($val["from"]),false,"AND",true);
						if(@$val["to"])
							$criteria->compare($attr,"<=" . strtotime($val["to"]),false,"AND",true);
						break;
					case "_number_range":
						if(@$val["from"])
							$criteria->compare($attr,">=" . $val["from"],false,"AND",true);
						if(@$val["to"])
							$criteria->compare($attr,"<=" . $val["to"],false,"AND",true);
						break;
					case "_datetime_range":
						// $val is an array
						if(@$val["from"])
							$criteria->compare($attr,">=" . $val["from"],false,"AND",true);
						if(@$val["to"])
							$criteria->compare($attr,"<=" . $val["to"],false,"AND",true);
						break;
					default:
						$criteria->compare($attr,$val,true,"AND",true);
						break;
				}
			}
		}

		if($table["join"]){
			$criteria->select = "t.*";
			foreach($table["join"] as $alias => $joinItem){
				foreach($joinItem["selected_properties"] as $prop => $replace){
					$selected_prop = $prop;
					if(strpos($prop,"(")===false){
						$selected_prop = $alias . "." . $prop;
					}
					$criteria->select .= "," . $selected_prop . " as " . $replace;
				}
				$criteria->join .= $joinItem["type"] .  " (" . $joinItem["table"] . ") " . $alias . " on ";
				$i = 0;
				foreach($joinItem["on"] as $k => $val){
					if($i>0)
						$criteria->join .= " and ";
					$criteria->join .= $alias . "." . $k . "=" . $val . " ";
					$i++;
				}
			}
		}

		if($table["select"]){
			foreach($table["select"] as $k => $v){
				$criteria->select .= ", (" . $v . ") as " . $k;
			}
		}

		if($table["with"]){
			$criteria->with = $table["with"];
		}

		//$criteria->select = "t.*, l.name as location_name, c.name as customer_name";
		//$criteria->join = "left join (select id, name from {{location}})l on l.id = t.location_id left join (select id, name from {{customer}})c on c.id = t.customer_id";



		$criteria->order = $order;
		$criteria->limit = $per_page;
		$criteria->offset = ($page-1)*$per_page;

		//print_r($criteria);die();

		return $criteria;
	}

	protected function handleUpdateField($object,$column,$table){
		$val = $this->input_post($column);
		if(empty($val) && $table["fields"][$column]["type"]=="_password"){
			return "";
		}
		if($val===false && $table["fields"][$column]["type"]=="_checkbox")
		{
			$val = 0;
		}
		if($val!==false)
			$object->setAttribute($column,$val);
		return $val;
	}

	protected function tableInsert($table){
		$modelClass = $table["model"];
		$obj = new $modelClass($table["insertScenario"]);
		$fields = $table["actions"]["_new"]["attr"];
		foreach($fields as $field){
			$val = $this->handleUpdateField($obj,$field,$table);
//			if($val===false)
//			{
//				$this->returnError($field." is error");
//				return;
//			}
		}
                if($table["formUpload"]){
			ModelFile::findFromInputSingle($obj);
		}
		if(isset($table["actions"]["_new"]["extend"]))
		{
			foreach($table["actions"]["_new"]["extend"] as $key => $value){
				$obj->$key = $value;
			}
		}
		//print_r($obj);die();
		if(!$obj->save(true))
			$this->returnError(Util::getFirstError($obj),array(
				"errors" => $obj->getErrors()
			));
		$this->returnSuccess();
	}

	protected function tableUpdate($table)
	{
		$editable = $table["actions"]["_edit"];
		$modelClass = $table["model"];
		if(!is_array($editable) || !isset($editable[0]))
		{
			$this->returnError();
			return;
		}

		$id = $this->input_post($table["primary"]);

		if($this->input_get("multiple")){
			$objects = $modelClass::model()->updateAll($this->input_post("attrs"),$table["primary"]." in (". implode(",", $id) .") ");
			$this->returnSuccess();
			return;
		}

		$criteria=new CDbCriteria();

		if($table["condition"]){
			foreach($table["condition"] as $key => $val){
				if(is_numeric($key))
				{
					$criteria->addCondition($val);
					continue;
				}
				$criteria->compare($key,$val,false,"AND",false);
			}
		}

		$attr = array();
		$attr[$table["primary"]] = $id;

		$object = $modelClass::model()->findByAttributes($attr,$criteria);

		if(!$object)
		{
			$this->returnError("This item does not exist");
			return;
		}

		$object->scenario = $table["updateScenario"];
		if($table["formUpload"]){
			ModelFile::findFromInputSingle($object);
		}
		foreach($editable as $column)
		{
			$this->handleUpdateField($object,$column,$table);	
		}

		if(!$object->save(true))
		{
			$this->returnError(Util::getFirstError($object),array(
				"errors" => $object->getErrors()
			));
		}
		else
		{
			$this->returnSuccess();
		}
	}

	protected function tableDelete($table)
	{
		$modelClass = $table["model"];
		if($this->input_get("multiple")){
			$objects = $modelClass::model()->deleteAll($table["primary"]." in (". implode(",", $this->input_post($table["primary"])) .") ");
			$this->returnSuccess();
			return;
		}

		$id = $this->input_post($table["primary"]);

		$criteria=new CDbCriteria();

		if($table["condition"]){
			foreach($table["condition"] as $key => $val){
				if(is_numeric($key))
				{
					$criteria->addCondition($val);
					continue;
				}
				$criteria->compare($key,$val,false,"AND",false);
			}
		}

		$attr = array();
		$attr[$table["primary"]] = $id;

		$object = $modelClass::model()->findByAttributes($attr,$criteria);

		if(!$object)
		{
			$this->returnError();
			return;
		}
		$result;
		if($table["deleteCompletedly"])
		{
			$result = $object->delete();
		}	
		else
		{
			$object->is_active = 0;
			$result = $object->save(true,array("is_active"));
		}
		if(!$result)
		{
			$this->returnError(Util::getFirstError($object),array(
				"errors" => $object->getErrors()
			));
		}
		else
		{
			$this->returnSuccess();
		}
	}

	protected function tableOrder($table)
	{
		$orders = $this->input_post("orders");
		if(!$orders)
			return;
		$whenSql = "";
		foreach($orders as $order)
		{
			$whenSql .= "WHEN ".$order["id"]." THEN '".$order["index"]."'";
		}
		$sql = "UPDATE ".$table["model"]::model()->tableName()." SET order_index = CASE id ".$whenSql." END ";
		Yii::app()->db->createCommand($sql)->execute();
	}

	protected function addAsset(){

		parent::addAsset();

		$table = @$this->data["table"];

		if(!$table)
			return;
		
		$this->generateTableJSON();
		//$this->data["table"] = $table;	
	}

	protected function generateTableJSON()
	{
		$table = @$this->data["table"];
		if(!$table)
			return;

		if($table["dragToReOrder"]){

			$this->useAssetExtension("jquery-ui");
			$this->useAssetExtension("angular","angular-ui");
		}

		$cs = Yii::app()->getClientScript();
		$cs->registerScript("admin-table-script",'
				var TableConfig = '.json_encode($table).';
		',CClientScript::POS_HEAD);
	}

	protected function renderAdditionalFiles($position)
	{
		$files = $this->data["table"]["additionalFiles"][$position];
		if($files==null)
			return;
		if(is_array($files))
		{
			foreach($files as $file)
			{
				$this->renderPartial($file,array(
					"table" => $this->data["table"]
				));
			}
		}
		else
		{
			$this->renderPartial($files,array(
				"table" => $this->data["table"]
			));
		}
	}

	protected function getView($viewName){
		$path = "ext.AdminTable.views.".$viewName;
		$themeViewPath = "webroot.themes.".$this->getTheme().".views.admin-table.".$viewName;
		if(file_exists(YiiBase::getPathOfAlias($themeViewPath).".php"))
			$path = $themeViewPath;
		return $path;
	}

	protected function renderViewTable()
	{
		$this->renderView($this->getView("AdminTable"));
	}

	protected function renderPartialTable($tableName){
		$this->data["table"] = $this->getTable($tableName);
		$this->data["isPartial"] = true;
		$this->generateTableJSON();
		$this->renderPartial($this->getView("AdminTable"),$this->data);
	}

	protected function renderPartialView($viewName,$data=false){
		if($data===false)
			$data = $this->data;
		$this->renderPartial($this->getView($viewName),$data);
	}

	protected function isPost($postVar=null)
	{
		$return = Yii::app()->getRequest()->getIsPostRequest() && isset($_POST["do"]);
		if($postVar!=null)
		{
			if(is_array($postVar))
			{
				foreach($postVar as $var)
				{
					$return = $return && isset($_POST[$var]);		
				}
			}
			else
			{
				$return = $return && isset($_POST[$postVar]);
			}
		}
		return $return;
	}

	// override

	protected abstract function getFileLocation();

	protected function getFolderLocation(){
		return "pages";
	}

	protected function getTheme(){
		return "admin";
	}

	protected function getBrandName(){
		return "AdminHQ";
	}

	protected function hasLoggedIn(){
		return !Yii::app()->user->isGuest;
	}

	protected function getLoginUrl(){
		return $this->createUrl("/site/login");
	}

	protected function getLogoutUrl(){
		return $this->createUrl("/site/logout");
	}

	protected function getUsername(){
		return Yii::app()->user->name;
	}

	protected function getActionLogin(){
		return false;
	}

	protected function getControllerLogin(){
		return "home";
	}

	protected function isRequiredLogin(){
		return true;
	}

	protected function beforeAction($action)
	{
		if($this->isRequiredLogin() && !$this->hasLoggedIn() && ($action->id!=$this->getActionLogin() || $this->id!=$this->getControllerLogin()))
		{
			$this->redirect($this->getLoginUrl());
			return false;
		}
		return parent::beforeAction($action);
	}
}