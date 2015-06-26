<?php

class FormBootstrap extends CFormModel {

	protected $form;

	protected $defaultSetup = array(
		"title" => array(
			"text" => false,
			"wrapper" => "h3",
			"attr" => array(
			)
		),
		"id" => "form",
		"attr" => array(
			"onsubmit" => "__validate(this,event)",
			"class" => "form"
		),
		"method" => "post",
		"url" => "",
		"upload" => false,
		"submit" => array(
			"text" => "Submit",
			"position" => "left",
			"attr" => array(
				"class" => "btn btn-primary",
				"type" => "submit"
			)
		),
		"loading" => array(
			"data-loading" => "1",
			"class" => "loading pull-right"
		),
		"type" => "no_label", // "label_above", "label_left",
		"label_col" => 3,
		"defaultInput" => array(
			"attr" => array(
				"class" => "form-control",
				"type" => "text"
			),
			"type" => "text"
		),
		"model" => null
	);

	protected $setup = array();

	protected function _setup(){
		return array();
	}

	public function init(){
		parent::init();

		$this->setup = array_replace_recursive($this->defaultSetup, $this->_setup());
		foreach($this->attributeNames() as $name){
			if(isset($this->setup["inputs"][$name]))
				continue;
			$this->setup["inputs"][$name] = array();
		}
		foreach($this->setup["inputs"] as $inputName => &$input){
			$input = array_replace_recursive($this->setup["defaultInput"], $input);
			if(!isset($input["attr"]["placeholder"]))
				$input["attr"]["placeholder"] = $this->getAttributeLabel($inputName);
		}
		//print_r($this->setup);die();
		if($this->setup["model"]){
			$this->setAttributes($this->setup["model"]->getAttributes());
		}
	}

	public function extractForm(){
		$this->openForm();
		$this->title();
		$this->inputs();
		$this->submit();
		$this->endForm();
	}

	public function openForm(){
		Yii::import("ext.Core.views.formTop",true);
		if($this->setup["upload"]){
			$this->setup["attr"]["enctype"] = "multipart/form-data";
		}
		if($this->setup["type"]=="label_left"){
			$this->setup["attr"]["class"] .= " form-horizontal" ;
		}
		$this->form = Yii::app()->controller->beginWidget('CActiveForm', array(
            'id'=>$this->setup["id"],
            "method" => $this->setup["method"],
            "action" => $this->setup["url"],
            'htmlOptions' => $this->setup["attr"],
        ));
        show_error($this,"global");
	}

	public function title(){
		$title = $this->setup["title"];
		if($title["text"]===false)
			return;
		echo CHtml::tag($title["wrapper"],$title["attr"],$title["text"]);
	}

	public function input($inputName,$hasWrapper=true,$hasLabel=true){
		$input = $this->setup["inputs"][$inputName];
		$type = $input["type"];
		if($type=="hidden"){
			echo $this->form->hiddenField($this,$inputName,$input["attr"]);
			return;
		}

		show_error($this,$inputName);

		if($hasWrapper){
			echo CHtml::openTag("div",array(
				"class" => "form-group"
			));
		}

		if($hasLabel){

			if($this->setup["type"]=="label_above"){
				echo $this->form->label($this,$inputName,array(
					"class" => "control-label"
				));
			} else if($this->setup["type"]=="label_left"){
				echo $this->form->label($this,$inputName,array(
					"class" => "control-label col-lg-".$this->setup["label_col"]
				));
				echo CHtml::openTag("div",array(
					"class" => "col-lg-".(12-$this->setup["label_col"])
				));
			}

		}

		switch($type){
			case "textarea":
				echo $this->form->textArea($this,$inputName,$input["attr"]);
				break;
			case "checkbox":
				echo $this->form->checkBox($this,$inputName,$input["attr"]);
				break;
			case "checkboxlist":
				echo $this->form->checkBoxList($this,$inputName,$input["data"],$input["attr"]);
				break;
			case "radio":
				echo $this->form->radioButton($this,$inputName,$input["attr"]);
				break;
			case "radioList":
				echo $this->form->radioButtonList($this,$inputName,$input["data"],$input["attr"]);
				break;
			case "select":
				echo $this->form->dropDownList($this,$inputName,$input["data"],$input["attr"]);
				break;
			case "file":
				echo $this->form->fileField($this,$inputName,$input["attr"]);
				break;
			case "password":
				echo $this->form->passwordField($this,$inputName,$input["attr"]);
				break;
			default: // text
				echo $this->form->textField($this,$inputName,$input["attr"]);
				break;
		}

		if($hasLabel){
			if($this->setup["type"]=="label_above"){
				// do nothing
			} else if($this->setup["type"]=="label_left"){
				echo CHtml::closeTag("div");
			}
		}

		if($hasWrapper){
			echo CHtml::closeTag("div");
		}
	}

	public function inputs(){
		foreach($this->setup["inputs"] as $inputName => $input){
			$this->input($inputName);
		}
	}

	public function submit($hasWrapper=true){
		$submit = $this->setup["submit"];
		if($submit===false)
			return;
		if($hasWrapper){
			echo CHtml::openTag("div",array(
				"class" => "row"
			));
			echo CHtml::openTag("div",array(
				"class" => "col-lg-12 text-".$submit["position"]
			));
		}
		echo CHtml::htmlButton($submit["text"],$submit["attr"]);
		$this->loading();

		if($hasWrapper){
			echo CHtml::closeTag("div");
			echo CHtml::closeTag("div");
		}
	}

	public function loading(){
		if($this->setup["loading"]!==false){
			echo CHtml::openTag("div",$this->setup["loading"]);
			echo CHtml::closeTag("div");
		}
	}

	public function endForm(){
		Yii::app()->controller->endWidget();
	}

	public function handleForm(){
		$data;
		if($this->setup["method"]=="get"){
			$data = Yii::app()->controller->input_get($this->getFormName());
		} else {
			// post
			$data = Yii::app()->controller->input_post($this->getFormName());
		}
		if($data===false){
			return false;
		}
		$this->setAttributes($data);
		ModelFile::findFromInput($this->getFormName(),$this);
		$result = $this->validate();
		if(!$result){
			$this->onFormValidatedFail();
			return false;
		}
		$result = $this->onFormValidatedSuccess();
		if(!$result)
			return false;
		$this->onFormDone();
		return true;
	}


	protected function getFormName(){
		return get_class($this);
	}

	public function rules(){
		return array(
			array(implode(",", $this->attributeNames()), "default")
		);
	}

	public function attributeLabels(){
		if($this->setup["model"]){
			return $this->setup["model"]->attributeLabels();
		}
		return array();
	}

	//

	protected function onFormValidatedFail(){}
	protected function onFormValidatedSuccess(){
		if($this->setup["model"]){
			$this->setup["model"]->setAttributes($this->getAttributes());
			$result = $this->setup["model"]->save();
			if(!$result){
				$this->addErrorGlobal();
			}
			return $result;
		}
		return true;
	}
	protected function onFormDone(){
		Yii::app()->controller->refresh();
	}

	public function addErrorGlobal($message=false){
		if($message===false && $this->setup["model"]){
			$message = Util::getFirstError($this->setup["model"]);
		}
		$this->addError("global",$message);
	}

}