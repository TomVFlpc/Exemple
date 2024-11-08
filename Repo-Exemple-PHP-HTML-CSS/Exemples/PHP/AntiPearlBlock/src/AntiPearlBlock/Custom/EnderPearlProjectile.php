<?php

namespace AntiPearlBlock\Custom;

use AntiPearlBlock\Main;
use pocketmine\entity\Location;
use pocketmine\entity\projectile\Throwable;
use pocketmine\item\ProjectileItem;
use pocketmine\player\Player;

class EnderPearlProjectile extends ProjectileItem {

    protected function createEntity(Location $location, Player $thrower): Throwable {
        return new EnderPearlEntity($location, $thrower);
    }

    public function getMaxStackSize(): int {
        return Main::$config->get("config-plugin")["ender-pearl"]["stack-size"];
    }

    public function getThrowForce(): float {
        return Main::$config->get("config-plugin")["ender-pearl"]["throw-force"];
    }

    public function getCooldownTicks(): int {
        return 20;
    }
}