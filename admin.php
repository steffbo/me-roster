<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<title>minimal effort Roster</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<?php

include "util.php";

// simple login check
if(isset($_POST['pw'])) {	
	if (md5($_POST['pw']) === Admin::PASSWORD_HASH) {
		setcookie('admin', 'foo', time() + 3600);
		echo 'login succesful';
	} else {
		exit("login failed");
	}
} else {
	if (!checkLogin()) {
		exit("no access");
	}
}


/**
 * Possible arguments in $_GET
 * i() = import data from battle.net API.
 * 
 * a(action) -> action to change a member
 *  a = s -> change spec of a member
 *  a = r -> toggle roster of a member
 *  
 * n(charName)
 * s(specNumber)
 * 
 */

/**
 * Load members.
 *   
 */
if (!isset($_GET['i'])) {
	$members = StorageHelper::unserialize(Store::MEMBER);
} else {
	$json = StorageHelper::loadJson(2);
	$members = StorageHelper::importMembersFromJson($json);
	StorageHelper::serialize(Store::MEMBER, $members);
}

/** 
 * Actions to change a member.
 * 
 * 	change spec of character
 * 	example: ?a=s&n=<memberName>&s=<newSpecNumber>
 * 
 * 	switch roster flag of character
 * 	example: ?a=r&n=<memberName>
 * 
*/

if (isset($_GET['a'])) {
	
	$action = $_GET['a'];	
	
	switch($action) {
		// spec
		case "s":
			$memberName = $_GET['n'];
			$newSpecNumber = $_GET['s'];
			$memberToChange = MemberHelper::getMemberByName($members, $memberName);
			$newSpec = new Spec($memberToChange->classNumber, $newSpecNumber);			
			$memberToChange->spec = $newSpec;
			break;
		// roster
		case "r": 
			$memberName = $_GET['n'];
			$memberToChange = MemberHelper::getMemberByName($members, $memberName);
			$memberToChange->roster = ($memberToChange->roster) ? false : true;
			$memberToChange->getPrimaryProfessions();			
			break;
	}
	StorageHelper::serialize(Store::MEMBER, $members);
	StorageHelper::putRosterNames();
}

/**
 * Display members.
 * 
 */
DisplayAdmin::admin($members);
DisplayAdmin::options();

?>

</body>
</html>