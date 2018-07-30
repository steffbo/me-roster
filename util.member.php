<?php

class MemberHelper {

	/**
	 * Returns the name to a class number.
	 *
	 * @param number $classNumber
	 * @return string
	 */
	public static function getClassName($classNumber) {
		switch($classNumber) {
			case 1: return 'Warrior';
			case 2: return 'Paladin';
			case 3: return 'Hunter';
			case 4: return 'Rogue';
			case 5: return 'Priest';
			case 6: return 'Deathknight';
			case 7: return 'Shaman';
			case 8: return 'Mage';
			case 9: return 'Warlock';
			case 10: return 'Monk';
			case 11: return 'Druid';
			default: return NULL;
		}
	}
	
	/**
	 * Returns the name to a rank number.
	 *
	 * @param number $rank
	 * @return string
	 */
	public static function getRankName($rank) {
		switch($rank) {
			case 0: return "Guild Master";
			case 1: return "Bank";
			case 2: return "minimalist";
			case 3: return "trialist";
			case 4: return "Koeh der Woche";
			case 5: return "Chef de Cuisine";
			case 6: return "Kimi";
			case 7: return "Community";
			case 8: return "ProgressBremse";
			case 9: return "rank 10";
		}
	} 
	
	/**
	 * Retrieve currently active guild members.
	 * A player is considered active when his API information are complete.
	 * Sorted by name.
	 *
	 * @param array $member array of objects of class Member
	 * @return array of objects of class Member
	 */
	public static function getActiveMembers($member) {
		$i = 0;
		$filteredMember = NULL;
		foreach ($member as $m) {
			if (!$m->active) continue;
			$filteredMember[$i++] = $m;
		}
		if (isset($filteredMember))
			usort($filteredMember, array('MemberHelper', 'sortByName'));
		return $filteredMember;
	}
	
	/**
	 * Retrieve currently active guild members.
	 * A player is considered active when his API information are complete.
	 * Sorted by class.
	 *
	 * @param array $member array of objects of class Member
	 * @return array of objects of class Member
	 */
	public static function getInactiveMembers($member) {
		$i = 0;
		$filteredMember = NULL;
		foreach ($member as $m) {
			if ($m->active) continue;
			$filteredMember[$i++] = $m;
		}
		if (isset($filteredMember))
			usort($filteredMember, array('MemberHelper', 'sortByClass'));
		return $filteredMember;
	}

	/**
	 * Retrieve current roster.
	 * Sorted by name.
	 *
	 * @param array $member array of Member
	 * @return array of Member
	 */
	public static function getRosterMembers($members) {
		$i = 0;
		$filteredMember = NULL;
		foreach($members as $m) {
			if (!$m->roster) continue;
			$filteredMember[$i++] = $m;
		}
		if (isset($filteredMember))
			usort($filteredMember, array('MemberHelper', 'sortByName'));
		return $filteredMember;
	}
	
	/**
	 * Retrieve the amount of roster members.
	 *
	 * @param array $member array of Member
	 * @return number
	 */
	public static function getRosterMemberCount($member) {
		$i = 0;
		$amount = 0;
		foreach($member as $m) {
			if (!$m->roster) continue;
			$amount++;
			$i++;
		}		
		return $amount;
	}

	/**
	 * Retrieve all members with a specific role. 
	 * Distance is optional to differentiate between DPS.
	 * Sorted by name.
	 *
	 * @param array $member array of Member
	 * @param string $role see Role const
	 * @param string $distance see Distance const
	 * @return array of Member
	 */
	public static function getMembersByRoleAndDistance($members, $role, $distance=NULL) {		
		$filteredMember = NULL;
		$i = 0;
		if (!isset($distance)) {
			foreach ($members as $m) {
				if ($m->spec->role == $role)
					$filteredMember[$i++] = $m;
			}
		} else {
			foreach ($members as $m) {
				if ($m->spec->role == $role && $m->spec->distance == $distance)
					$filteredMember[$i++] = $m;
			}
		}
		if (isset($filteredMember))
			usort($filteredMember, array('MemberHelper', 'sortByName'));
		return $filteredMember;
	}
	
	/**
	 * Retrieve all members with a specific guild rank.
	 * Sorted by class.
	 *
	 * @param array $member array of Member
	 * @param number $rank see Role const
	 * @return array of Member
	 */
	public static function getMembersByRank($members, $rank) {		
		$filteredMember = NULL;		
		$i = 0;
		foreach ($members as $m) {
			if ($m->rank == $rank)
				$filteredMember[$i++] = $m;
		}
		if (isset($filteredMember))
			usort($filteredMember, array('MemberHelper', 'sortByClass'));
		return $filteredMember;
	}

	/**
	 * Retrieves the index of a Member object.
	 *
	 * @param array $member array of Member
	 * @param string $name name of the character to retrieve
	 * @return number|NULL
	 */
	public static function getMemberIndexByName($member, $name) {
		$i = 0;
		foreach($member as $m) {
			if ($m->name === $name) return $i;
			$i++;
		}
		return NULL;
	}

	/**
	 * Retrieves a Member by index.
	 *
	 * @param array $member array of Member
	 * @param number $name index of the character to retrieve
	 * @return number|NULL
	 */
	public static function getMemberByIndex($member, $index) {
		return $member[$index];
	}
	
	/**
	 * Retrieves a single Member object.
	 *
	 * @param array $member array of Member
	 * @param string $name name of the character to retrieve
	 * @return Member|string
	 */
	public static function getMemberByName($member, $name) {
		foreach($member as $m)
		if ($m->name === $name) return $m;
		return NULL;
	}
	
	/**
	 * Sorts ascending by name.
	 *
	 * @param Member $a
	 * @param Member $b
	 * @return number
	 */
	public static function sortByName($a, $b) {
		return strnatcmp($a->sortName, $b->sortName);
	}
	
	/**
	 * Sorts descending by role (TANK > HEALING > DPS), then ascending by name.
	 *
	 * @param Member $a
	 * @param Member $b
	 * @return number
	 */
	public static function sortByRole($a, $b) {
		$specA = $a->spec;
		$specB = $b->spec;
		$rdiff = strnatcmp($specB->role, $specA->role);
		if ($rdiff) return $rdiff;
		return strnatcmp($a->sortName, $b->sortName);
	}
	
	/**
	 * Sorts ascending by class, then ascending by name.
	 *
	 * @param Member $a
	 * @param Member $b
	 * @return number
	 */
	public static function sortByClass($a, $b) {
		$rdiff = strnatcmp($a->getClassName(), $b->getClassName());
		if ($rdiff) return $rdiff;
		return strnatcmp($a->sortName, $b->sortName);
	}
	
	/**
	 * Sorts ascending by guild rank, then ascending by class, then ascending by name.
	 *
	 * @param Member $a
	 * @param Member $b
	 * @return number
	 */
	public static function sortByRankAndClass($a, $b) {
		$rdiff = strnatcmp($a->rank, $b->rank);
		if ($rdiff) return $rdiff;
		$rdiff = strnatcmp($a->getClassName(), $b->getClassName());
		if ($rdiff) return $rdiff;
		return strnatcmp($a->sortName, $b->sortName);
	}

}

?>