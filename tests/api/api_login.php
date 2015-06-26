<?php
$I = new ApiGuy($scenario);
$I->wantTo('create a user via API');
$I->haveHttpHeader('Content-Type','application/x-www-form-urlencoded');
$I->sendPOST('users', array('username' => 'k@gmail.com', 'Password' => ''));
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('{"message":"Password","success":0}');
?>

?>

