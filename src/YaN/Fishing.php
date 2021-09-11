<?php

namespace YaN;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use YaN\utils\FishingLootTable;
use YaN\utils\FishingLevel;
use YaN\entity\EntityManager;
use YaN\item\ItemManager;

class Fishing extends PluginBase {
	
	/** @var Fishing */
	private static $instance = null;
	/** @var Session[] */
	private $sessions = [];
	
	public static Config $cacheFile;
	public static Config $config;
	public static Config $levelFile;
	
	public $lang;
	
	public static $randomFishingLootTables = true;
	public static $registerVanillaEnchantments = true;

	public static function getInstance(): Fishing{
		return self::$instance;
	}
	
	public function onLoad(){
	    if(!self::$instance instanceof Fishing){
	        self::$instance = $this;
	    }
		@mkdir($this->getDataFolder());
		self::$cacheFile = new Config($this->getDataFolder() . "cache.json", Config::JSON);
		self::$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		//Lang init
        new Config($this->getDataFolder() . 'lang.yml', Config::YAML, array(
            "lvlup" => "§aLEVEL UP",
            "lvltoolownight" => "§cYour level is to low to fishing in night",
            "fishsize" => "size",
            "fishhasgoneaway" => "§aTo late fish run away!",
            "linebreaklvltoolow" => "§aLevel Low Broken Rope",
            "tooslowfishhasgoneaway" => "§aFish run away",
        ));
		
		$this->lang = (array)yaml_parse_file($this->getDataFolder() . "lang.yml");
	}
	
    public function onEnable(){
		FishingLootTable::init();
		FishingLevel::init();
		ItemManager::init();
		EntityManager::init();
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
	}
	
	public function getSessionById(int $id){
		if(isset($this->sessions[$id])){
			return $this->sessions[$id];
		}else{
			return null;
		}
	}	
	
	public function createSession(Player $player): bool{
		if(!isset($this->sessions[$player->getId()])){
			$this->sessions[$player->getId()] = new Session($player);
			$this->getLogger()->debug("Created " . $player->getName() . "'s Session");

			return true;
		}

		return false;
	}	
	
	public function destroySession(Player $player): bool{
		if(isset($this->sessions[$player->getId()])){
			unset($this->sessions[$player->getId()]);
			$this->getLogger()->debug("Destroyed " . $player->getName() . "'s Session");

			return true;
		}

		return false;
	}
}
