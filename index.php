<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>minimal effort Roster</title>
<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>

<?php

include "util.php";

// simple login check
$loginStatus = checkLogin();

$members = StorageHelper::unserialize(Store::MEMBER);
$rosterMembers = MemberHelper::getRosterMembers($members);
DisplayRoster::seperatedByRoles($rosterMembers);
DisplayRoster::options($loginStatus);

?>

</body>
</html>