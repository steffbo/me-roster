<?php

class Spec {
	
	public $className;
	public $classNumber;
	public $specName;
	public $specNumber;
	
	public $backgroundImage;
	public $distance;
	public $icon;
	public $role;	
	
	public function __construct($classNumber, $specNumber) {
		
		switch($classNumber) {
			case 1:
				$className = 'Warrior';
				switch($specNumber) {
					case 0:
						$specName = 'Arms';
						$backgroundImage = 'bg-warrior-arms';
						$distance = Distance::CLOSE;
						$icon = 'ability_warrior_savageblow';						
						$role = Role::DPS;						
						break;
					case 1:
						$specName = 'Fury';
						$backgroundImage = 'bg-warrior-fury';
						$distance = Distance::CLOSE;
						$icon = 'ability_warrior_innerrage';						
						$role = Role::DPS;						
						break;
					case 2:
						$specName = 'Protection';
						$backgroundImage = 'bg-warrior-protection';
						$distance = Distance::CLOSE;
						$icon = 'ability_warrior_defensivestance';
						$role = Role::TANK;
						break;
				} break;
			case 2:
				$className = 'Paladin';
				switch($specNumber) {
					case 0:
						$specName = 'Holy';
						$backgroundImage = 'bg-paladin-holy';
						$distance = Distance::RANGE;
						$icon = 'spell_holy_holybolt';
						$role = Role::HEALING;
						break;
					case 1:
						$specName = 'Protection';
						$backgroundImage = 'bg-paladin-protection';
						$distance = Distance::CLOSE;
						$icon = 'ability_paladin_shieldofthetemplar';						
						$role = Role::TANK;						
						break;
					case 2:
						$specName = 'Retribution';
						$backgroundImage = 'bg-paladin-retribution';
						$distance = Distance::CLOSE;
						$icon = 'spell_holy_auraoflight';						
						$role = Role::DPS;						
						break;
				} break;
			case 3:
				$className = 'Hunter';
				switch($specNumber) {
					case 0:
						$specName = 'Beast Mastery';
						$icon = 'ability_hunter_bestialdiscipline';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-hunter-beastmaster';
						break;
					case 1:
						$specName = 'Marksmanship';
						$icon = 'ability_hunter_focusedaim';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-hunter-marksman';
						break;
					case 2:
						$specName = 'Survival';
						$icon = 'ability_hunter_camouflage';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-hunter-survival';
						break;
				} break;
			case 4:
				$className = 'Rogue';
				switch($specNumber) {
					case 0:
						$specName = 'Assassination';
						$icon = 'ability_rogue_eviscerate';
						$distance = Distance::CLOSE;
						$role = Role::DPS;
						$backgroundImage = 'bg-rogue-assassination';
						break;
					case 1:
						$specName = 'Combat';
						$icon = 'ability_backstab';
						$distance = Distance::CLOSE;
						$role = Role::DPS;
						$backgroundImage = 'bg-rogue-combat';
						break;
					case 2:
						$specName = 'Subtlety';
						$icon = 'ability_stealth';
						$distance = Distance::CLOSE;
						$role = Role::DPS;
						$backgroundImage = 'bg-rogue-subtlety';
						break;
				} break;
			case 5:
				$className = 'Priest';
				switch($specNumber) {
					case 0:
						$specName = 'Discipline';
						$icon = 'spell_holy_powerwordshield';
						$distance = Distance::RANGE;
						$role = Role::HEALING;
						$backgroundImage = 'bg-priest-discipline';
						break;
					case 1:
						$specName = 'Holy';
						$icon = 'spell_holy_guardianspirit';
						$distance = Distance::RANGE;
						$role = Role::HEALING;
						$backgroundImage = 'bg-priest-holy';
						break;
					case 2:
						$specName = 'Shadow';
						$icon = 'spell_shadow_shadowwordpain';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-priest-shadow';
						break;
				} break;
			case 6:
				$className = 'Deathknight';
				switch($specNumber) {
					case 0:
						$specName = 'Blood';
						$icon = 'spell_deathknight_bloodpresence';
						$distance = Distance::CLOSE;
						$role = Role::TANK;
						$backgroundImage = 'bg-deathknight-blood';
						break;
					case 1:
						$specName = 'Frost';
						$icon = 'spell_deathknight_frostpresence';
						$distance = Distance::CLOSE;
						$role = Role::DPS;
						$backgroundImage = 'bg-deathknight-frost';
						break;
					case 2:
						$specName = 'Unholy';
						$icon = 'spell_deathknight_unholypresence';
						$distance = Distance::CLOSE;
						$role = Role::DPS;
						$backgroundImage = 'bg-deathknight-unholy';
						break;
				} break;
			case 7:
				$className = 'Shaman';
				switch($specNumber) {
					case 0:
						$specName = 'Elemental';
						$icon = 'spell_nature_lightning';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-shaman-elemental';
						break;
					case 1:
						$specName = 'Enhancement';
						$icon = 'spell_shaman_improvedstormstrike';
						$distance = Distance::CLOSE;
						$role = Role::DPS;
						$backgroundImage = 'bg-shaman-enhancement';
						break;
					case 2:
						$specName = 'Restoration';
						$icon = 'spell_nature_magicimmunity';
						$distance = Distance::RANGE;
						$role = Role::HEALING;
						$backgroundImage = 'bg-shaman-restoration';
						break;
				} break;
			case 8:
				$className = "Mage";
				switch($specNumber) {
					case 0:
						$specName = 'Arcane';
						$icon = 'spell_holy_magicalsentry';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-mage-arcane';
						break;
					case 1:
						$specName = 'Fire';
						$icon = 'spell_fire_firebolt02';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-mage-fire';
						break;
					case 2:
						$specName = 'Frost';
						$icon = 'spell_frost_frostbolt02';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-mage-frost';
						break;
				} break;
			case 9:
				$className = "Warlock";
				switch($specNumber) {
					case 0:
						$specName = 'Affliction';
						$icon = 'spell_shadow_deathcoil';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-warlock-affliction';
						break;
					case 1:
						$specName = 'Demonology';
						$icon = 'spell_shadow_metamorphosis';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-warlock-demonology';
						break;
					case 2:
						$specName = 'Destruction';
						$icon = 'spell_shadow_rainoffire';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-warlock-destruction';
						break;
				} break;
			case 10:
				$className = "Monk";
				switch($specNumber) {
					case 0:
						$specName = 'Brewmaster';
						$icon = 'spell_monk_brewmaster_spec';
						$distance = Distance::CLOSE;
						$role = Role::TANK;
						$backgroundImage = 'bg-monk-brewmaster';
						break;
					case 1:
						$specName = 'Mistweaver';
						$icon = 'spell_monk_mistweaver_spec';
						$distance = Distance::RANGE;
						$role = Role::HEALING;
						$backgroundImage = 'bg-monk-mistweaver';
						break;
					case 2:
						$specName = 'Windwalker';
						$icon = 'spell_monk_windwalker_spec';
						$distance = Distance::CLOSE;
						$role = Role::DPS;
						$backgroundImage = 'bg-monk-battledancer';
						break;
				} break;
			case 11:
				$className = "Druid";
				switch($specNumber) {
					case 0:
						$specName = 'Balance';
						$icon = 'spell_nature_starfall';
						$distance = Distance::RANGE;
						$role = Role::DPS;
						$backgroundImage = 'bg-druid-balance';
						break;
					case 1:
						$specName = 'Feral';
						$icon = 'ability_druid_catform';
						$distance = Distance::CLOSE;
						$role = Role::DPS;
						$backgroundImage = 'bg-druid-cat';
						break;
					case 2:
						$specName = 'Guardian';
						$icon = 'ability_racial_bearform';
						$distance = Distance::CLOSE;
						$role = Role::TANK;
						$backgroundImage = 'bg-druid-bear';
						break;
					case 3:
						$specName = 'Restoration';
						$icon = 'spell_nature_healingtouch';
						$distance = Distance::RANGE;
						$role = Role::HEALING;
						$backgroundImage = 'bg-druid-restoration';
						break;
				} break;
		}
		
		$this->classNumber = $classNumber;
		$this->className = $className;
		$this->specNumber = $specNumber;
		$this->specName = $specName;
		$this->icon = $icon;
		$this->distance = $distance;
		$this->role = $role;
		$this->backgroundImage = $backgroundImage;		
		
	}
	
	/**
	 * Gives the location to the icon of the class specialisation.
	 *
	 * @return string
	 */
	public function getIconLocation() {
		$local = Images::LOCAL_ICON_PATH . $this->icon . Images::LOCAL_EXTENSION;
		$hotlink = Images::HOTLINK_PATH . $this->icon . Images::HOTLINK_EXTENSION;					
		return (Images::HOTLINKING) ? $hotlink : $local;
	}
	
}

?>