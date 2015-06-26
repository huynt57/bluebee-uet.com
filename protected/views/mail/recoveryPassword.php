<h3 style="font-weight:normal; margin: 20px 0;"><?php echo Yii::t(Yii::app()->params['TRANSLATE_FILE'],'Password Recovery');?></h3>
<p style="font-size:12px; line-height:18px;">
	<?php echo Yii::t(Yii::app()->params['TRANSLATE_FILE'],'We just received a recovery password request from you:');?>
	<br /><br />
	
	<?php echo Yii::t(Yii::app()->params['TRANSLATE_FILE'],'Email');?>: <a href="#"><?php echo $administrator->username ;?></a>
</p>
<p style="font-size:12px; line-height:18px;">
	<?php echo Yii::t(Yii::app()->params['TRANSLATE_FILE'],'This is the new password for your account: ');?><?php echo $new_password ;?>
</p>
<p style="font-size:12px; line-height:18px;">
	
</p>