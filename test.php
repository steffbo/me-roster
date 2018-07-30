<?php

include 'util.php';

 $json = StorageHelper::loadJson(2);
 $members = StorageHelper::importMembersFromJson($json);
 $rosterMembers = MemberHelper::getRosterMembers($members);

// var_dump($rosterMembers);


// current test function
testShowMembersWithProfession($rosterMembers);

function testShowMembersWithProfession($members) {
	foreach ($members as $m) {
		echo "Name: " . $m->name . " 1: " . $m->professions[0]->name . " 2: " . $m->professions[1]->name . "<br/>";
	}
}

function testChangeMemberSpec($members, $memberName, $newOrder) {

	// get member
	$memberToChange = getMemberByName($members, $memberName);
	echo "memberToChange: <br/>";
	var_dump($memberToChange);
	echo "<br/><br/>";	
	
	// change!
	echo "changing ...<br/><br/>";
	$memberToChange->spec->order = $newOrder;	
	
	// see if it worked
	echo "changedMember: <br/>";
// 	$changedMember = getMemberByName($members, $memberName);	
	var_dump($members);
	echo "<br/><br/>";
}

function testGetMembersByRoleAndDistance() {
	$member = getMembersByRoleAndDistance($member, Role::DPS, '');
	usort($member, array('MemberHelper', 'sortMember'));
	
	foreach($member as $m) {
		echo $m->name;
		echo "<br/>";
	}
}

function testGetMemberIndexByName($member, $name) {
	$index = getMemberIndexByName($member, $name);
	$memberByIndex = getMemberByIndex($member, $index);
	echo "index: ".$index."<br/>";
	var_dump($memberByIndex);
}

function testGetClassSpecs() {
	echo "<div style='-webkit-column-count: 11;'>";
	
	for($i = 1; $i <= 11; $i++) {
		echo "<div style='-webkit-column-break-inside: avoid;'>";
		echo "<b>".Member::getClassName($i)."</b><br/>";
			
		for($j = 0; $j <= 3; $j++) {				
			if ($i!=11 && $j==3) continue;
			$classSpec = Spec::getClassSpec($i, $j);
			
			echo $classSpec['name'];
			echo "<br/>";
			echo "<img src='".$classSpec['icon']."'>";
			echo "<br/>";
		}
		echo "</div>";
	}
	echo "</div>";
}


// TODO
// template for output


// admin.php improve css columns
// render page


// admin.php
// -> get current char properties via character api 
// -> edit chars

		
		
?>


