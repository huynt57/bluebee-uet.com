<?php
class CoreController extends Controller{
	var $data = array(
	);
	public $coreAssets, $commonAssets;
	var $commonTheme = "__common";
	public $headerTitle = "";
	public $autoloadAssets = true;

	protected function getTheme(){
		return Yii::app()->theme->name;
	}

	public function init()
	{
		parent::init();
		$this->headerTitle =  Util::param("SITE_NAME");
		$theme = $this->getTheme();
		if(Yii::app()->theme->name!=$theme)
			Yii::app()->theme = $theme;
		$this->coreAssets = Yii::app()->params["assets"][$theme];
		$this->commonAssets = Yii::app()->params["assets"][$this->commonTheme];
	}

	public function l($url,$echo=false){
		$url = $this->createUrl($url);
		if($echo){
			echo $url;
		}
		return $url;
	}

	public function md($url,$echo=false){
		return $this->l("/" . $this->module->getName() . "/" . $url,$echo);
	}

	protected function addAsset(){
		if(!$this->autoloadAssets)
			return;
		$this->addAssetCore(false,$this->coreAssets["css"]);
		$this->addAssetCore($this->coreAssets["js"]);

		$autoLoadCommon = @$this->coreAssets["extensions"]["__autoLoadCommon"];
		$extensions = $this->coreAssets["extensions"];
		if($autoLoadCommon===true){
			// if has autoload => merge extensions
			$extensions = array_merge($this->commonAssets["extensions"],$this->coreAssets["extensions"]);
		} else if (is_array($autoLoadCommon)){
			// if has autoload array, load extension in the array
			foreach($autoLoadCommon as $extension_name){
				$this->useAssetExtension($extension_name);
			}
		}
		foreach($extensions as $extension_name => $arr){
			if($extension_name[0]=="_")
				continue;
			if($arr===false){
				continue;
			}
			if($arr===true){
				$this->useAssetExtension($extension_name);
				continue;
			}
			if(isset($arr["auto"]) && $arr["auto"]===false){
				continue;
			}
			$this->useAssetExtension($extension_name);
		}

		if(isset($this->coreAssets["custom"]))
		{
			$this->addAssetCustom($this->coreAssets["custom"]["js"],$this->coreAssets["custom"]["css"]);
		}
	}

	public function render($view,$data=array(),$return=false){
		$this->addAsset();
		return parent::render($view,$data,$return);
	}
	protected function renderView($view)
	{
		$this->render($view,$this->data);
	}
	protected function renderPartialView($view,$data=false)
	{
		if($data===false)
			$data = $this->data;
		$this->renderPartial($view,$data);
	}
	public function getAssetFolder($to_file="",$useCommon=false){
		$path =  Yii::app()->theme->baseUrl . "/assets/";
		if($useCommon)
			$path =  Yii::app()->theme->baseUrl . "/../../themes/" . $this->commonTheme . "/assets/";
		return $path . $to_file;
	}

	public function useAssetExtension($name, $folder=null){
		$useCommon = false;
		if(isset($this->coreAssets["extensions"][$name]) && $this->coreAssets["extensions"][$name]!==true){
			$arr = $this->coreAssets["extensions"][$name];
		} else {
			$arr = $this->commonAssets["extensions"][$name];
			$useCommon = true;
		}
		if($folder!=null){
			$arr = $arr[$folder];
		}
		$js_files = isset($arr["js"]) ? $arr["js"] : false;
		$css_files = isset($arr["css"]) ? $arr["css"] : false;
		$this->addAssetExtension($name,$js_files,$css_files,$useCommon);
	}

	public function addAssetCore($js_files=false, $css_files=false){
		$cs = Yii::app()->getClientScript();

		if($js_files){
			$useCommonJS = ($js_files===true);
			if($useCommonJS){
				$js_files = $this->commonAssets["js"];
			}

			foreach($js_files as $key => $value){
				if($value==1){
					// extenal file
					$cs->registerScriptFile($key);
				} else {
					$cs->registerScriptFile($this->getAssetFolder("core/js/".$value,$useCommonJS));
				}
			}
		}
		if($css_files){
			$useCommonCSS = ($css_files===true);
			if($useCommonCSS){
				$css_files = $this->commonAssets["css"];
			}

			foreach($css_files as $key => $value){
				if($value==1){
					// extenal file
					$cs->registerCssFile($key);
				} else {
					$cs->registerCssFile($this->getAssetFolder("core/css/".$value,$useCommonCSS));	
				}
			}
		}
	}
	public function addAssetCustom($js_files=array(),$css_files=array()){
		$cs = Yii::app()->getClientScript();

		if($js_files){
			if(is_array($js_files)){
				// an array of files
				foreach($js_files as $key => $value){
					if($value==1){
						// extenal file
						$cs->registerScriptFile($key,CClientScript::POS_END);
					} else {
						$cs->registerScriptFile($this->getAssetFolder("custom/js/".$value),CClientScript::POS_END);
					}
				}
			} else {
				// filename = filename
				$cs->registerScriptFile($this->getAssetFolder("custom/js/".$js_files),CClientScript::POS_END);
			}
		}
		if($css_files){
			if(is_array($css_files)){
				// an array of files
				foreach($css_files as $key => $value){
					if($value==1){
						// extenal file
						$cs->registerCssFile($key);
					} else {
						$cs->registerCssFile($this->getAssetFolder("custom/css/".$value));
					}
				}
			} else {
				// filename = filename
				$cs->registerCssFile($this->getAssetFolder("custom/css/".$css_files));
			}
		}
	}
	public function addAssetModule($js_files=array(),$css_files=array()){
		$cs = Yii::app()->getClientScript();

		//$path = "/application/modules/".$this->module->getName()."/assets/";
		$path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.'."admin".'.assets'),false,-1,true);

		if($js_files){
			if(is_array($js_files)){
				// an array of files
				foreach($js_files as $key => $value){
					if($value==1){
						// extenal file
						$cs->registerScriptFile($key,CClientScript::POS_END);
					} else {
						$cs->registerScriptFile($path . "/js/".$value,CClientScript::POS_END);
					}
				}
			} else {
				// filename = filename
				$cs->registerScriptFile($path . "/js/".$js_files,CClientScript::POS_END);
			}
		}
		if($css_files){
			if(is_array($css_files)){
				// an array of files
				foreach($css_files as $key => $value){
					if($value==1){
						// extenal file
						$cs->registerCssFile($key);
					} else {
						$cs->registerCssFile($path . "/css/".$value);
					}
				}
			} else {
				// filename = filename
				$cs->registerCssFile($path . "/css/".$css_files);
			}
		}
	}
	public function addAssetExtension($extension_name,$js_files=true, $css_files=true, $useCommon=false){
		$cs = Yii::app()->getClientScript();

		if($js_files){
			if(is_array($js_files)){
				// an array of files
				foreach($js_files as $key => $value){
					if($value==1){
						// extenal file
						$cs->registerScriptFile($key,CClientScript::POS_END);
					} else {
						$cs->registerScriptFile($this->getAssetFolder("extensions/".$extension_name."/js/".$value,$useCommon),CClientScript::POS_END);
					}
				}
			} elseif($js_files===true) {
				// filename = extension_name
				$cs->registerScriptFile($this->getAssetFolder("extensions/".$extension_name."/js/".$extension_name.".js",$useCommon),CClientScript::POS_END);
			} else {
				// filename = filename
				$cs->registerScriptFile($this->getAssetFolder("extensions/".$extension_name."/js/".$js_files,$useCommon),CClientScript::POS_END);
			}
		}
		if($css_files){
			if(is_array($css_files)){
				// an array of files
				foreach($css_files as $key => $value){
					if($value==1){
						// extenal file
						$cs->registerCssFile($key);
					} else {
						$cs->registerCssFile($this->getAssetFolder("extensions/".$extension_name."/css/".$value,$useCommon));
					}
				}
			} elseif($css_files===true) {
				// filename = extension_name
				$cs->registerCssFile($this->getAssetFolder("extensions/".$extension_name."/css/".$extension_name.".css",$useCommon));
			} else {
				// filename = filename
				$cs->registerCssFile($this->getAssetFolder("extensions/".$extension_name."/css/".$css_files,$useCommon));
			}
		}
	}
	//
	var $js_code_index = 0;
	public function startAssetJSCode()
	{
		ob_start();
	}
	public function endAssetJSCode()
	{
		$js_code = ob_get_clean();
		$js_code = str_replace("<script>", "", $js_code);
		$js_code = str_replace("</script>", "", $js_code);
		$cs = Yii::app()->getClientScript();
		$cs->registerScript("js_code_".($this->js_code_index++),$js_code,CClientScript::POS_END);
		//$cs->renderBodyEnd($js_code);

	}
	public function input_get($name,$default=false,$extendDefaultInsteadOfReplace=false)
	{
		return $this->input($name,"get",$default,$extendDefaultInsteadOfReplace);
	}
	public function input_post($name,$default=false,$extendDefaultInsteadOfReplace=false)
	{
		return $this->input($name,"post",$default,$extendDefaultInsteadOfReplace);
	}
	public function input_get_post($name,$default=false,$extendDefaultInsteadOfReplace=false)
	{
		return $this->input($name,"get_post",$default,$extendDefaultInsteadOfReplace);
	}
	public function input($name,$type="get_post",$default=false,$extendDefaultInsteadOfReplace=false)
	{
		switch($type)
		{
			case "get":
				return isset($_GET[$name]) ? $this->input_default($_GET[$name],$default,$extendDefaultInsteadOfReplace) : $default;
				break;
			case "post":
				return isset($_POST[$name]) ? $this->input_default($_POST[$name],$default,$extendDefaultInsteadOfReplace) : $default;
				break;
			case "get_post":
				return isset($_GET[$name]) ? $this->input_default($_GET[$name],$default,$extendDefaultInsteadOfReplace) : (isset($_POST[$name]) ? input_default($_POST[$name],$default,$extendDefaultInsteadOfReplace) : $default);
				break;
		}
	}
	public function input_default($input, $default=false,$extendDefaultInsteadOfReplace=false)
	{
		if(!$extendDefaultInsteadOfReplace)
			return $input;
		return array_merge_recursive($default,$input);

	}
	public function show_404($die=true){
		echo "404";
		if($die)
			die();
	}
	public function returnJSON($array)
	{
		echo CJSON::encode($array);
		Yii::app()->end();
	}
	public function returnSuccess($data=array(),$message="Ok")
	{
		$this->returnJSON(array(
			"success" => 1,
			"message" => $message,
			"data" => $data
		));
	}
	public function returnError($message="Error occurs",$data=array())
	{
		$this->returnJSON(array(
			"success" => 0,
			"message" => $message,
			"data" => $data
		));	
	}
}