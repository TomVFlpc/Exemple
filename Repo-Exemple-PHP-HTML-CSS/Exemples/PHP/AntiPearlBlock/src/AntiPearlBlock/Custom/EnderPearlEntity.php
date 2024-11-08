<?php

namespace AntiPearlBlock\Custom;

use AntiPearlBlock\Main;
use AntiPearlBlock\Utils\AntiPearlBlockManager;
use pocketmine\block\Block;
use pocketmine\entity\projectile\Throwable;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\RayTraceResult;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\world\particle\EndermanTeleportParticle;
use pocketmine\world\sound\EndermanTeleportSound;

class EnderPearlEntity extends Throwable {

    /**
     * @param Block
     * @param RayTraceResult
     * @return void
     */
    public function onHitBlock(Block $blockHit, RayTraceResult $hitResult): void {

        $player = $this->getOwningEntity();

        if(!is_null($player)) {

            $blockResultVector = $hitResult->getHitVector();

            $this->flagForDespawn();

            if($blockHit->getId() === Main::$config->get("config-plugin")["anti-pearl-block"]["id"]) {

                AntiPearlBlockManager::sendCancelMessage($player);
                AntiPearlBlockManager::givePearlBack($player);
                return;
            }

            $world = $this->getWorld();

            $world->addParticle($origin = $player->getPosition(), new EndermanTeleportParticle());
            $world->addSound($origin, new EndermanTeleportSound());
            $world->addSound($blockResultVector, new EndermanTeleportSound());

            $player->teleport($blockResultVector);

            $player->attack(new EntityDamageEvent($player, EntityDamageEvent::CAUSE_FALL, Main::$config->get("config-settings")["ender-pearl-damage"]));
        }
    }

    /**
     * @return string
     */
    public static function getNetworkTypeId(): string {
        return EntityIds::ENDER_PEARL;
    }
}