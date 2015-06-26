<?php
$I = new WebGuy($scenario);
$I->wantTo('login and see result');
$I->amOnPage('WelcomePage');
$I->fillField('username', 'k@gmail.com');
$I->fillField('Password', '');
$I->click('Submit');
$I->see('Passaword', '#login-result');
?>