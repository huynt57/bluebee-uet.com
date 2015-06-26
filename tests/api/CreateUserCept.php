<?php
$I = new ApiGuy($scenario);
$I->wantTo('test login function');
//$I->haveHttpHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
$I->sendPOST(array('username' => 'k@gmail.com', 'Password' => ''));
//$I->seeResponseCodeIs(200);
//$I->seeResponseIsJson();
//$I->seeResponseContainsJson('{"message":"Password","success":0}');
?>