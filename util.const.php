<?php

class Admin { 
	const PASSWORD_HASH = "ab86a1e1ef70dff97959067b723c5c24";
}

class Guild {
	const NAME = "minimal%20effort";
	const SERVER = "Mannoroth";
	const REGION = "eu";
}

class Api {
	const HOST_EU = "http://eu.battle.net";
	const GUILD = "/api/wow/guild/";
	const GUILD_FIELDS = "members";
	const CHAR = "/api/wow/character/";
	const CHAR_FIELDS = "professions";
}

class Store {
	const MEMBER = "./db/member.txt";
	const JSON = "./db/json.txt";
	const ROSTER = "./db/roster.txt";
	const LOGIN = "./db/login.txt";
}

class Role {
	const TANK = "TANK";
	const HEALING = "HEALING";
	const DPS = "DPS";
	const DPS_CLOSE = "Melee DPS";
	const DPS_RANGE = "Range DPS";
}

class Distance {
	const CLOSE = "close";
	const RANGE = "range";
}

class Images {	
	const BLIZZARD_PATH = "http://eu.battle.net/static-render/eu/";
	const HOTLINKING = true;	
	const HOTLINK_PATH = "http://wow.zamimg.com/images/wow/icons/large/";
	const HOTLINK_EXTENSION = ".jpg";	
	const LOCAL_IMG_PATH = "./img/";
	const LOCAL_ICON_PATH = "./img/icons/";
	const LOCAL_EXTENSION = ".png";	
	const LOCAL_BACKGROUND_IMAGES = "./img/backgroundImages/";
}

?>