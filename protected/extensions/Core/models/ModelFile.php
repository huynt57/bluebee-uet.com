<?php

class ModelFile
{
    public $model;
    public $key, $name, $type, $tmp_name, $size, $error;

    // static functions

    public static function findFromInput($name,$model)
    {
        $files = array();
        if(!isset($_FILES[$name]))
            return false;
        $modelFiles = $_FILES[$name];
        foreach($modelFiles["name"] as $key => $fileName){
            $file = new ModelFile();
            $file->key = $key;
            $file->name = $modelFiles["name"][$key];
            $file->type = $modelFiles["type"][$key];
            $file->tmp_name = $modelFiles["tmp_name"][$key];
            $file->size = filesize($file->tmp_name);
            $file->error = $modelFiles["error"][$key];
                
            if($file->error)
            {
                $model->$key = null;
                continue;
            }
            $file->model = $model;
            $files[$key] = $file;
            $model->$key = $file;
        }
        return $files;
    }

    public static function findFromInputSingle($model){
        $files = array();
        foreach($_FILES as $key => $fileArr){
            $file = new ModelFile();
            $file->key = $key;
            $file->name = $fileArr["name"];
            $file->type = $fileArr["type"];
            $file->tmp_name = $fileArr["tmp_name"];
            $file->size = filesize($file->tmp_name);
            $file->error = $fileArr["error"];

            if($file->error)
            {
                $model->$key = null;
                continue;
            }
            $file->model = $model;
            $files[$key] = $file;
            $model->$key = $file;
        }
        return $files;
    }

    // functions

    var $_originKey = false;
    public function getOriginKey()
    {
        if($this->_originKey===false)
        {
            $map = @$this->model->modelFileMap();
            if($map==null || !isset($map[$this->key])){
                return false;
            }
            $this->_originKey = $map[$this->key];
        }
        return $this->_originKey;
    }

    public function getOriginKeyLabel()
    {
        return $this->model->getAttributeLabel($this->getOriginKey());
    }

    var $_extension = false;
    public function getExtension()
    {
        if($this->_extension===false){
            $fileParts = pathinfo($this->name);
            $this->_extension = $fileParts["extension"];
        }
        return $this->_extension;
    }

    public function checkType($types,$errorMessage=false){
        $arr;
        if(!is_array($types)){
            switch($types){
                case "_image":
                    $types = array('image/jpeg','image/jpg','image/pjpeg', 'image/x-png','image/png');
                    break;
                case "_document":
                    $types = array("application/pdf","application/x-pdf");
                    break;
                default:
                    $arr = array($types);
                    break;
            }
        }
        $result = in_array($this->type, $arr);
        if(!$result){
            if($errorMessage===false){
                $errorMessage = $this->getOriginKeyLabel() . " has an invalid file type";
            }
            $this->model->addError($this->getOriginKey(),$errorMessage);
        }
        return $result;
    }

    public function checkExt($types,$errorMessage=false){
        $arr = $types;
        if(!is_array($types)){
            switch($types){
                case "_image":
                    $arr = array('jpg','jpeg','gif','png');
                    break;
                case "_document":
                    $arr = array("pdf","doc","docx","html");
                    break;
                default:
                    $arr = array($types);
                    break;
            }
        }
        $result = in_array($this->getExtension(), $arr);
        if(!$result){
            if($errorMessage===false){
                $errorMessage = $this->getOriginKeyLabel() . " has an invalid file type";
            }
            $this->model->addError($this->getOriginKey(),$errorMessage);
        }
        return $result;
    }

    public function checkSize($min=-1,$max=-1,$errorMessage=false){
        $mb = $this->size / 1024 / 1024;
        $result = true;
        if($min!=-1){
            if($mb<$min){
                $result = false;
                if($errorMessage===false){
                    $this->model->addError($this->getOriginKey(),$this->getOriginKeyLabel() . "'s file size must be greater than " . $min);
                }
            }
        }
        if($max!=-1){
            if($mb>$max){
                $result = false;
                if($errorMessage===false){
                    $this->model->addError($this->getOriginKey(),$this->getOriginKeyLabel() . "'s file size must be less than " . $max);
                }
            }
        }

        if(!$result && $errorMessage!==false){
            $this->model->addError($this->getOriginKey(),$errorMessage);
        }

        return $result;
    }

    public function checkWidthHeightFixed($fixedWidth=-1, $fixedHeight=-1, $errorMessage=false){
        list($width, $height, $type, $attr) = getimagesize($this->tmp_name);
        $result = true;

        if($fixedWidth!=-1){
            if($width!=$fixedWidth){
                $result = false;
                if($errorMessage===false){
                    $this->model->addError($this->getOriginKey(),$this->getOriginKeyLabel() . "'s width must be equal to " . $fixedWidth);
                }
            }
        }

        if($fixedHeight!=-1){
            if($height!=$fixedHeight){
                $result = false;
                 if($errorMessage===false){
                    $this->model->addError($this->getOriginKey(),$this->getOriginKeyLabel() . "'s height must be equal to " . $fixedHeight);
                }
            }
        }

        if(!$result && $errorMessage!==false){
            $this->model->addError($this->getOriginKey(),$errorMessage);
        }

        return $result;
    }

    public function checkWidthHeightMin($maxWidth=-1, $maxHeight=-1, $errorMessage=false){
        list($width, $height, $type, $attr) = getimagesize($this->tmp_name);
        $result = true;

        if($fixedWidth!=-1){
            if($width!=$fixedWidth){
                $result = false;
                if($errorMessage===false){
                    $this->model->addError($this->getOriginKey(),$this->getOriginKeyLabel() . "'s width must be greater than " . $fixedWidth);
                }
            }
        }

        if($fixedHeight!=-1){
            if($height!=$fixedHeight){
                $result = false;
                 if($errorMessage===false){
                    $this->model->addError($this->getOriginKey(),$this->getOriginKeyLabel() . "'s height must be less greater " . $fixedHeight);
                }
            }
        }

        if(!$result && $errorMessage!==false){
            $this->model->addError($this->getOriginKey(),$errorMessage);
        }

        return $result;
    }

    public function checkWidthHeightMax($minWidth=-1, $minHeight=-1, $errorMessage=false){
        list($width, $height, $type, $attr) = getimagesize($this->tmp_name);
        $result = true;

        if($fixedWidth!=-1){
            if($width!=$fixedWidth){
                $result = false;
                if($errorMessage===false){
                    $this->model->addError($this->getOriginKey(),$this->getOriginKeyLabel() . "'s width must be less than " . $fixedWidth);
                }
            }
        }

        if($fixedHeight!=-1){
            if($height!=$fixedHeight){
                $result = false;
                 if($errorMessage===false){
                    $this->model->addError($this->getOriginKey(),$this->getOriginKeyLabel() . "'s height must be less than " . $fixedHeight);
                }
            }
        }

        if(!$result && $errorMessage!==false){
            $this->model->addError($this->getOriginKey(),$errorMessage);
        }

        return $result;
    }

    public function save($folder, $name=null){
        if($name==null){
            $name = $this->name;
        }
        $result = move_uploaded_file($this->tmp_name, $folder . "/" . $name);
        return $result;
    }

    public function saveToCloud($updateModelToDB=false){
        $link = Yii::app()->rscloud->storeUploadedFile($this->tmp_name,$this->getExtension());
        $result = $link!==false ? true : false;
        $this->model->setAttribute($this->getOriginKey(),$link);
        if($result && $updateModelToDB){
            $this->model->save(false,array(
                $this->getOriginKey()
            ));
        }
        return $result;
        //return "//cloud/".$this->name;
    }
}