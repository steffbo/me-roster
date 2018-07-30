<?php

class Profession {
	
	public $name;
	public $icon;
	public $curSkill;
	public $maxSkill;
	
	public function __construct($name, $icon, $curSkill, $maxSkill) {		
		$this->name = $name;
		$this->icon = $icon;
		$this->curSkill = $curSkill;
		$this->maxSkill = $maxSkill;		
	}
	
}

?>