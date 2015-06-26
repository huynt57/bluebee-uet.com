<!-- Begin Main Menu -->
<div class="phpmaker">
<?php $RootMenu = new cMenu("RootMenu"); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, $Language->MenuPhrase("1", "MenuText"), "tbl_subjectlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(2, $Language->MenuPhrase("2", "MenuText"), "tbl_subject_doclist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(3, $Language->MenuPhrase("3", "MenuText"), "tbl_teacherlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(4, $Language->MenuPhrase("4", "MenuText"), "tbl_subject_facultylist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(5, $Language->MenuPhrase("5", "MenuText"), "tbl_subject_grouplist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(6, $Language->MenuPhrase("6", "MenuText"), "tbl_subject_group_typelist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(7, $Language->MenuPhrase("7", "MenuText"), "tbl_subject_teacherlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(8, $Language->MenuPhrase("8", "MenuText"), "tbl_subject_typelist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(9, $Language->MenuPhrase("9", "MenuText"), "tbl_teacher_faculty_positionlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(11, $Language->MenuPhrase("11", "MenuText"), "tbl_userlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(12, $Language->MenuPhrase("12", "MenuText"), "tbl_doclist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(13, $Language->MenuPhrase("13", "MenuText"), "tbl_deptlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(14, $Language->MenuPhrase("14", "MenuText"), "tbl_facultylist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(15, $Language->MenuPhrase("15", "MenuText"), "tbl_lessonlist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(25, $Language->MenuPhrase("25", "MenuText"), "tbl_lesson_doclist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(26, $Language->MenuPhrase("26", "MenuText"), "tbl_lesson_videolist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(-1, $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
