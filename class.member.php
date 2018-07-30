<?php

function getNames() {
	$names = file_get_contents(Store::ROSTER);
	$names = explode(" ", $names);
	return $names;
}

class Member {

	// char
	public $name;
	public $rank;
	public $classNumber;
	public $thumbnail;	
	public $sortName;	
	public $spec;
	
	// professions (only loaded for marked roster members)
	public $professions;
	
	// flags
	public $active;
	public $roster = false;
	

	/**
	 * Constructor for new Member.
	 * 
	 * @param string $name
	 * @param number $rank
	 * @param number $class
	 * @param string $thumbnail
	 * @param Spec|null $spec
	 */
	public function __construct($name, $rank, $classNumber, $thumbnail, $spec) {
		
		$this->name = $name;
		$this->rank = $rank;
		$this->classNumber = $classNumber;
		$this->thumbnail = $thumbnail;
		$this->spec = $spec;				
		$this->active = ($spec != NULL);
		
		$rosterNames = StorageHelper::getRosterNames();
		if (in_array($name, $rosterNames)) {
			$this->getPrimaryProfessions();
			$this->roster = true;			
		}
		
		// workaround for special characters that natsort doesn't handle
		$s = array("Ð" => "D");
		$this->sortName = strtr($name, $s);
	}
	
	/**
	 * Gives the location to the avatar.
	 * 
	 * @return string
	 */
	public function getThumbnailLocation() {
		return Images::BLIZZARD_PATH . $this->thumbnail;
	}

	/**
	 * Returns the class name.
	 * 
	 * @return string
	 */
	public function getClassName() {		
		return MemberHelper::getClassName($this->classNumber);
	}

	/**
	 * Retrieves all specialisations for this class.
	 * 
	 * @return array of classSpec
	 */
	public function getAllSpecsForClass() {
		for ($i = 0; $i <= 3; $i++) {
			// skip order 3 for all classes but druids because only they have 4 specs
			if ($i == 3 && $this->classNumber != 11) continue;
			$spec[$i] = new Spec($this->classNumber, $i);
		}	
		return $spec;
	}
	
	/**
	 * Retrieve the primary professions for this character.
	 */
	public function getPrimaryProfessions() {
		$apiCall = API::HOST_EU . API::CHAR . Guild::SERVER ."/". $this->name ."?fields=". API::CHAR_FIELDS;
		@$json = file_get_contents($apiCall);
		
		$character = json_decode($json, true);
// 		var_dump($json);
		
		if ($character['professions']['primary']) {
		
			foreach($character['professions']['primary'] as $p) {
				$name = $p['name'];
				$icon = $p['icon'];
				$curSkill = $p['rank'];
				$maxSkill = $p['max'];
				
				$profession = new Profession($name, $icon, $curSkill, $maxSkill);
				$professions[] = $profession;
			}
			
			$this->professions = $professions;
			
		} else return NULL;
		
	}
	
}

?>