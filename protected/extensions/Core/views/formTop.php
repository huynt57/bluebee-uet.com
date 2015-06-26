<?php

function show_error($model,$name,$extra="")
{
    if(!$model)
        return false;
    $errors = $model->getErrors($name);
    if(!count($errors))
        return false;
    ?>
        <span class="help-block error"><?php echo $errors[0].$extra ?></span>
    <?php
    return true;
}
function show_error_class($model,$name)
{
    if(!$model)
        return;
    $errors = $model->getErrors($name);
    if(!count($errors))
        return;
    echo " error";
}
function input_text_value($model,$name,$default="")
{
    if(!$model)
    {
        echo $default;
        return;
    }
    echo $model->$name;
}
function input_select_value($model,$name,$value,$default="")
{
    $checked = ' selected="selected"';
    if(!$model)
    {
        if($value==$default)
            echo $checked;
        return;
    }
    //$val=$model->getAttributes($name); 
    $val = $model->$name;
    if($val && $val==$value)
        echo $checked;
}
function input_checkbox_value($model,$name,$value="1",$default=true)
{
    $checked = ' checked="checked"';
    if(!$model)
    {
        if($default)
            echo $checked;
        return;
    }
    //$val=$model->getAttributes($name); 
    $val = $model->$name;
    if($val && $val==$value)
        echo $checked;   
}
?>
<style>
    .error-display.error, .error
    {
        color: #b94a48;
    }
    .help-block
    {
        margin-top:5px;
    }
</style>