<?php

error_reporting(-1);

include_once "display.php";
include_once "class.member.php";
include_once "class.spec.php";
include_once "class.profession.php";
include_once "util.const.php";
include_once "util.member.php";
include_once "util.storage.php";

function checkLogin() {	
	if (isset($_GET['logout'])) {
		unset($_COOKIE['admin']);
		setcookie(setcookie('admin', '', -1));
	}
	return (isset($_COOKIE['admin'])) ? true : false;
}


?>