<?php

class DisplayRoster {
	
	public static function options($isLoggedIn) {
		if ($isLoggedIn) {
			echo "<div class='options'><a href='admin.php'>admin</a></div>";
		} else {
			echo 
				"<div class='options'>"
				."<form action='admin.php' method='post'>"
				."admin: <input id='pw' name='pw' type='password'>"
				."</form>"
				."</div>";
		}
	}
	
	/* index page */
	public static function seperatedByRoles($rosterMembers) {
		echo "<div class='roster-roles'>";
		
		$roleMembersTank = MemberHelper::getMembersByRoleAndDistance($rosterMembers, Role::TANK);		
		DisplayRoster::role(ucfirst(strtolower(Role::TANK)), $roleMembersTank);
	
		$roleMembersRangeDps = MemberHelper::getMembersByRoleAndDistance($rosterMembers, Role::DPS, Distance::RANGE);
		DisplayRoster::role(Role::DPS_RANGE, $roleMembersRangeDps);
		
		$roleMembersHealing = MemberHelper::getMembersByRoleAndDistance($rosterMembers, Role::HEALING);
		DisplayRoster::role(ucfirst(strtolower(Role::HEALING)), $roleMembersHealing);
	
		$roleMembersMeleeDps = MemberHelper::getMembersByRoleAndDistance($rosterMembers, Role::DPS, Distance::CLOSE);
		DisplayRoster::role(Role::DPS_CLOSE, $roleMembersMeleeDps);
		
		// $roleMembersDps = MemberHelper::getMembersByRoleAndDistance($members, Role::DPS);
		// Display::role(Role::DPS, $roleMembersDps);
	
		echo "</div>";
	}
	
	private static function role($role, $roleMembers) {
		echo 
			"<div class='roster-role'>"
			."<div class='roster-role-head'>".$role."</div>"
			."<div class='roster-role-body'>";
		
		foreach($roleMembers as $member)
			DisplayRoster::member($member);
		
		echo "</div></div>";
	}
	
	private static function member($member) {
		$memberName = $member->name;
		$thumbnail = $member->getThumbnailLocation();
		$specIcon = $member->spec->getIconLocation();
		$specName = $member->spec->specName;
		$className = $member->spec->className;		
		$armoryLink = "http://eu.battle.net/wow/en/character/mannoroth/". $member->name ."/advanced";
		$armoryIcon = Images::LOCAL_IMG_PATH ."armory". Images::LOCAL_EXTENSION;
		
		// profession information
		$professions = $member->professions;
		// 1
		$profession1Name = $professions[0]->name;
		$profession1CurSkill = $professions[0]->curSkill;
		$profession1MaxSkill = $professions[0]->maxSkill;
		$profession1Icon = Images::HOTLINK_PATH . $professions[0]->icon . Images::HOTLINK_EXTENSION;
		// 2
		$profession2Name = $professions[1]->name;
		$profession2CurSkill = $professions[1]->curSkill;
		$profession2MaxSkill = $professions[1]->maxSkill;
		$profession2Icon = Images::HOTLINK_PATH . $professions[1]->icon . Images::HOTLINK_EXTENSION;
		
		echo 
			"<a href='". $armoryLink ."' target='_blank'>"
			."<div class='roster-member'>"
		
		// thumbnail		
			."<div class='roster-member-thumbnail'>"
			."<img src='". $thumbnail ."' alt='Thumb' title='". $memberName ."'>"
			."</div>"
		
			."<div class='roster-member-info'>"
					
			// spec		
				."<div class='roster-member-spec'>"
				."<img src='". $specIcon ."' title='". $specName ."' alt='". $specName ."'>"
				."</div>"
						
			// professions
				."<div class='roster-member-professions'>"
				."<img src='".$profession1Icon."' alt='". $profession1Name ."' title='". $profession1Name . " " . $profession1CurSkill . "/" . $profession1MaxSkill . "'>"
				."<img src='".$profession2Icon."' alt='". $profession2Name ."' title='". $profession2Name . " " . $profession2CurSkill . "/" . $profession2MaxSkill . "'>"
				."</div>"
					
			."</div>"
					
		// name		
			."<div class='roster-member-name class_". $className ."'>"
			.$memberName
			."</div>"		
		
		// armory		 
			."<div class='roster-member-armory'>"
			."<a href='". $armoryLink ."' target='_blank'>"
			."<img src='". $armoryIcon ."' alt='Armory' title='Armory'>"
			."</a></div>"
			."</div>" // roster-member
			."</a>"; 
	}
	
}

class DisplayAdmin {
	
	/* admin page */
	public static function admin($members) {	
		$activeMembers = MemberHelper::getActiveMembers($members);
		$inactiveMembers = MemberHelper::getInactiveMembers($members);
		$rosterMembers = MemberHelper::getRosterMembers($members);
		
		// all active guild members seperated by rank		
		echo "<div class='admin-ranks'>";	
		
		// each rank
		for ($i = 0; $i < 10; $i++) {
			$rankMembers = MemberHelper::getMembersByRank($activeMembers, $i);
			if (isset($rankMembers))
				DisplayAdmin::adminRank($rankMembers, $i);
		}
	
		// inactive like a rank		
		DisplayAdmin::adminInactive($inactiveMembers);
	
		echo "</div>";
	
		// current roster member		
		usort($rosterMembers, array('MemberHelper', 'sortByRole'));
		DisplayAdmin::adminRoster($rosterMembers);		
	}

	public static function options() {
		echo
			"<div class='options'>"
			."<a href='./'>index</a> "
			."<a href='./?logout'>(logout)</a><br/>"
			."<a href='admin.php?i'>import from battle.net</a><br/>"
			."</div>";
	}
	
	private static function adminRank($members, $rank=NULL) {		
		$rankName = MemberHelper::getRankName($rank);
		$countRank = count($members);
		$countRoster = MemberHelper::getRosterMemberCount($members);
		
		echo 
			"<div class='admin-rank'>"
			
			// head
			."<div class='admin-rank-head'>"
			.$rankName
			."<div class='admin-roster-amount'>"
			."roster: " . $countRoster . "/" . $countRank
			."</div></div>"
			
			// body
			."<div class='admin-rank-body'>";
		
		foreach ($members as $member) {
			$className = MemberHelper::getClassName($member->classNumber);
			$currentMemberSpec = $member->spec;
			$memberName = $member->name;
			$specIcon = $currentMemberSpec->getIconLocation();
			$specName = $currentMemberSpec->specName;
			$isRoster = ($member->roster) ? 'enabled' : 'disabled';			
			
			echo 
				"<div class='admin-member class_". $className ."'>"
				."<a href='./admin.php?a=r&n=". $memberName ."'>"
				."<img src='". Images::LOCAL_IMG_PATH . $isRoster . Images::LOCAL_EXTENSION ."' title='". $isRoster ."'>"
				."</a>"
				.$memberName
			
				// spec Icons
				."<div class='admin-spec-icons'>"			
				."<div class='admin-spec-icon active'>"
				."<img src='". $specIcon ."' title='". $specName ."'>"
				."</div></div></div>"; // admin-spec-icon, admin-spec-icons, admin-member 
		}
				
		echo "</div></div>"; // admin-rank-body, admin-rank
	}
	
	private static function adminInactive($members) {
		echo 
			"<div class='admin-rank'>"
			."<div class='admin-rank-head'>"
			."inactive"
			."</div>"
			."<div class='admin-rank-body inactive'>";
		
		foreach ($members as $member) {			
			$memberName = $member->name;
			$className = MemberHelper::getClassName($member->classNumber);
			
			echo 
				"<div class='admin-member class_". $className ."'>"
				.$memberName
				."</div>";			
		}
		echo "</div>"; // admin-rank-body
		
	}
		
	private static function adminRoster($members) {
		
		$tanks = MemberHelper::getMembersByRoleAndDistance($members, Role::TANK);
		$healer = MemberHelper::getMembersByRoleAndDistance($members, Role::HEALING);
		$dps = MemberHelper::getMembersByRoleAndDistance($members, Role::DPS);		
		$countTanks = count($tanks);
		$countHealer = count($healer);
		$countDps = count($dps);
	
		echo 
			"<div class='admin-roster'>"
			."<div class='admin-roster-head'>"
			."current roster"
			."<div class='admin-roster-amount'>"
			.$countTanks. " / "
			.$countHealer. " / "
			.$countDps
			."</div>"
			."<div class='admin-roster-body'>";
		
			foreach ($members as $member) {
				$memberName = $member->name;
				$className = MemberHelper::getClassName($member->classNumber);
				$specIcon = $member->spec->getIconLocation();
				$currentSpecName = $member->spec->specName;
				$isRoster = ($member->roster) ? 'enabled' : 'disabled';
				
				echo 
					"<div class='admin-member class_". $className ."'>"
					."<a href='./admin.php?a=r&n=". $memberName ."'>"
					."<img src='". Images::LOCAL_IMG_PATH . $isRoster . Images::LOCAL_EXTENSION ."' title='". $isRoster ."'>"
					."</a>"
					.$memberName
					."<div class='admin-spec-icons'>";
					
				$specs = $member->getAllSpecsForClass();
				foreach($specs as $spec) {
					$specName = $spec->specName;
					$specIcon = $spec->getIconLocation();
					$specClassNumber = $spec->classNumber;
					$specNumber = $spec->specNumber;
					$isActiveSpec = ($currentSpecName == $specName);
				
					// image for each spec - link to change
					if ($isActiveSpec) {
						echo
						"<div class='admin-spec-icon active'>"
						."<img src='". $specIcon ."' title='". $specName ."'>"
						."</div>";
					} else {
						echo
						"<div class='admin-spec-icon'>"
						."<a href='./admin.php?a=s&n=". $memberName ."&s=". $specNumber ."'>"
						."<img src='". $specIcon ."' title='". $specName ."'>"
						."</a>"
						."</div>";
					}
				}
				echo "</div></div>"; // admin-spec-icons, admin-member
			}
			
		echo "</div></div>"; // admin-roster-body, admin-roster
	}
	
}

?>