<?php

declare(strict_types = 1);

namespace YaN\entity;


use YaN\entity\projectile\FishingHook;
use YaN\Fishing;
use pocketmine\entity\Entity;

class EntityManager extends Entity {
	public static function init(): void{
		// Projectiles ////
		self::registerEntity(FishingHook::class, true, ['FishingHook', 'minecraft:fishinghook']);
	}
}
