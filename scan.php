<?php
 
/*********************************************************
- Tool Scan shell vesion 1.0
- Code by KID
- Edit by : www.joomlaviet.vn
**********************************************************/
error_reporting (E_ALL);    // M? báo l?i
ini_set("memory_limit","2000M");
ini_set("safe_mode","off");
$safe_mode = @ini_get('safe_mode');
if (!$safe_mode)
set_time_limit(0);
if (@!isset($_POST['key']))
{
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Scan Shell v1.1</title>
<style>
body {
font-family:arial;
}
</style>
</head>
<body bgcolor=black text=blue size=2><center>
<form method='post' action=''>
<div style="border-style: solid; border-width: 1px; padding-left: 4px; padding-right: 4px; padding-top: 1px; padding-bottom: 1px">
<h1>Scan Shell - v1.1</h1>
                  <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Folder: <input type='text' size=70 name='folder' value='<?echo $_SERVER['DOCUMENT_ROOT']?>/'/></div>                   
                  &nbsp;<div>&nbsp; KeyWord:&nbsp; <input type='text' size=70 name='key' value='base64_decode'/></div> 
                  <p><input type='submit' name='submit' value='Tìm ki?m' /></p>  </div>
                  <div align=left><br>Step 1: Nh?p du?ng d?n thu m?c c?n scan</div>
                  <div align=left>Step 2: Nh?p t? khóa c?n tìm</div>
            </form>
 
<br><br>
---------------------------------------------------------------------------------
<br><br><i>Power By <a href="http://joomlaviet.vn"><font color=red>Joomla Vi?t</font></a><br>Copyright 2012<a href="http://diendan.joomlaviet.vn"><font color=yellow>Di?n Ðàn Joomla Vi?t</font></a><br/>
<br>---------------------------------------------------------------------------------
</center>
 
</body>
</html>
  <?
}
else
{
if ($_POST['folder']) $folder = $_POST['folder']; else $folder = $_SERVER['DOCUMENT_ROOT'];
define('Keyword',$_POST['key']);                                    // Tìm ki?m t? khóa
define('TAB',"&nbsp;&nbsp;&nbsp;&nbsp;");                       
define('IGNORE_EXTENSIONS',"jpg pdf zip psd doc gif swf xls gz txt");    // Không tìm nh?ng file
define("MAX_SIZE",1024*1024*1024);                                    // Size t?i da
define("IGNORE_BEFORE", strtotime('2009-08-01') );                // Tìm File tru?c ngày
$shell = $_SERVER["PHP_SELF"];
 
function findexts($filename)
{
    $filename = strtolower($filename) ;
    $exts = split("[/\\.]", $filename) ;
    $n = count($exts)-1;
    $exts = $exts[$n];
    return strtolower($exts);
}
 
function check_dir($directory,$level) {
    global $virus_detected, $all, $detect_errors_only, $detected_Keyword_in_test_script;
 
    $indent='';
    for ($count=0;$count<$level;$count++) {
        $indent.=TAB;
    }
    $level++;
    $read_dir=opendir($directory);    // M? thu m?c hi?n t?i
    while ($file=readdir($read_dir)) {
        $filepath=$directory.'/'.$file;
        if ($detect_errors_only && $virus_detected) {
            exit;
        }
        if (is_dir($filepath)) {
            // Thu m?c
            if ( ($file<>'.') && ($file<>'..') ) {
                check_dir($filepath,$level);
            }
        }
        else {
            if (is_file($filepath)) {
                // T?p
                if ( (is_readable($filepath) )  &&  (!stristr(IGNORE_EXTENSIONS, findexts($file)))  ) {
                    if ((filesize($filepath)< MAX_SIZE) && (filemtime($filepath)>IGNORE_BEFORE) ){
                        $fileentry=$directory.'/'.$file.' - '.date('j F Y H:i',filemtime($filepath));
                        $filestring=file_get_contents($filepath);
                        $found=stripos($filestring,Keyword); // PHP 5 ONLY
                        $found=stristr($filestring,Keyword);flush();
                        if ($found==false) {
                            if ( (!$detect_errors_only) && (!$all) ) {
                            echo($filepath.'  <font color=#FFFFFF>OK</font><br/>');
                            }
                        }
                        else {
                            if ($file=='scan_file.php'){
                                $detected_Keyword_in_test_script=true;
                            }
                            else {
                                $virus_detected=true;
                                if ($detect_errors_only) {
                                    echo('<b style="color:#F00">T?p tin d? ngh? phát hi?n</b><br/>');
                                }
                                else {
                                    echo(TAB.'<b style="color:#F00">'.$fileentry.'</b> - <b style="color:#FFFFF0">Phát hi?n</b><br/>');
                                }
                            }
                        }
                        $found='';
                    }
                    else {
                        if ( (!$detect_errors_only) && (!$all) ) {
                            echo($filepath.'  <b style="color:yellow">NOT CHECKED - File quá l?n</b><br/>');
                        }
                    }
                }
                else {
                    if ( (!$detect_errors_only) && (!$all) ) {
                        echo($filepath.'  <b style="color:yellow">NOT CHECKED - Không thu?c ki?u tìm ki?m</b><br/>');
                    }
                }
            }
            else {
            }
        }
    }   
    closedir($read_dir);
}
 
$virus_detected=false;
$all=true;
$detect_errors_only=false;
$detected_Keyword_in_test_script=false;
if (isset($_GET['all'])) {
    $all=false;
}
if (isset($_GET['detect_errors_only'])) {
    $detect_errors_only=true;
}
 
echo<<<END1
<html>
<head>
<title>Scan Shell v1.1</title>
<style>
body {
font-family:arial;
}
</style>
</head>
<body bgcolor=black text=blue size=2>
END1;
?>
<div style="border-style: solid; border-width: 1px; padding-left: 4px; padding-right: 4px; padding-top: 1px; padding-bottom: 1px">
<h1>Truy xu?t t? khóa "<?echo Keyword?>" trong h? th?ng !</h1>
B? qua l?i file : <font color=yellow><?echo IGNORE_EXTENSIONS?>.</font><br/>
B? qua file vu?t quá : <font color=yellow><?echo MAX_SIZE?> bytes.</font><br/>
Tìm ki?m file tru?c ngày :<font color=yellow> <?echo date('j F Y',IGNORE_BEFORE)?>.</font><br/><br></div>
<br/><br>[<a href="<?echo $shell?>?all">Hi?n th? t?t c??</a>]
<br/><br/>&nbsp;<br/>
<?
 
if ($all) {
    echo('<font color=yellow>List File</font><br/>');
}
check_dir($folder,0);
 
 
 
if ($virus_detected) {
    echo('<br/><b style="color:#f00">Tìm ki?m thành công!</b><br>&nbsp;<br/>');
}
else {
echo('<br/><b style="color:#f00">Không có file ch?a Key Word!</b><br>&nbsp;<br/>');
}
 
?>
</body>
</html>
<?
}
?>