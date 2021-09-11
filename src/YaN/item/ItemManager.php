<?php


declare(strict_types = 1);

namespace YaN\item;

use YaN\Fishing;
use pocketmine\item\{
	Item, ItemFactory
};

class ItemManager {
	public static function init(){
		ItemFactory::registerItem(new FishingRod(), true);
		Item::initCreativeItems();
	}
}
