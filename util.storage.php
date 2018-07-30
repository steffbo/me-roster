<?php

class StorageHelper {
	
	/**
	 * Load json data.
	 *
	 * @param number $source 1 battle.net API | 2 local json file
	 * @throws Exception failed to load json
	 * @return string json
	 */
	public static function loadJson($source=2) {			
		switch($source) {
			// import battle.net API
			case 1:
				$apiCall = API::HOST_EU . API::GUILD . Guild::SERVER ."/". Guild::NAME ."?fields=". API::GUILD_FIELDS;
				@$json = file_get_contents($apiCall);
				file_put_contents(Store::JSON, $json);
				break;
			// local file
			case 2:
			default:
				@$json = file_get_contents(Store::JSON);
				break;
		}
		if ($json == false) throw new Exception("failed to load");
		return $json;
	}
	
	/**
	 * New import of guild members over battle.net API.
	 * Sorted by rank and class.
	 *
	 * @param string $json
	 * @return Member
	 */
	public static function importMembersFromJson($json) {
		$m = json_decode($json, true);
		$i = 0;
		foreach($m['members'] as $p) {
	
			$name = $p['character']['name'];
			$rank = $p['rank'];
			$classNumber = $p['character']['class'];
			$thumbnail = $p['character']['thumbnail'];	
			$isActive = isset($p['character']['spec']);
				
			if ($isActive) {
				$specNumber = $p['character']['spec']['order'];
				$spec = new Spec($classNumber, $specNumber);
			} else $spec = NULL;
	
			$member[$i] = new Member($name, $rank, $classNumber, $thumbnail, $spec);
			$i++;
		}
		usort($member, array('MemberHelper', 'sortByRankAndClass'));
		return $member;
	}
	
	/**
	 * Stores a serialized object.
	 *
	 * @param string $store file where to store the serialize result
	 * @param ambigious $obj whatever shall be serialized
	 */
	public static function serialize($store, $obj) {
		file_put_contents($store, serialize($obj));
	}	
	
	/**
	 * Retrieves a serialized object.
	 *
	 * @param string $store file to unserialize
	 * @return object that was unserialized
	 */
	public static function unserialize($store) {
		$object = unserialize(file_get_contents($store));
		return $object;
	}
	
	/**
	 * Retrieves names of active roster characters. 
	 * Used to flag characters as roster members after importing from the battle.net API.
	 * 
	 * @return array
	 */
	public static function getRosterNames() {
		$roster = file_get_contents(Store::ROSTER);
		$roster = explode(" ", $roster);
		return $roster;
	}
	
	/**
	 * Stores the current roster.
	 * Helps flagging characters as roster members after importing from the battle.net API.
	 * 
	 */
	public static function putRosterNames() {
		$rosterMembers = MemberHelper::getRosterMembers(StorageHelper::unserialize(Store::MEMBER));
		$roster = "";
		$i = 0;
		foreach ($rosterMembers as $r) {
			// no space in front of first entry
			$roster .= ($i > 0) ? " " . $r->name : "" . $r->name;
			$i++;
		}
		file_put_contents(Store::ROSTER, $roster);
	}
	
}

?>