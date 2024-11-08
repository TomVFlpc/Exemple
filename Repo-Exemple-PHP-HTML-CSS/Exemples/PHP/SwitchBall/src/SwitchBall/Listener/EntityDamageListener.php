<?php

namespace SwitchBall\Listener;

use pocketmine\entity\projectile\Snowball;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\ItemIds;
use pocketmine\scheduler\ClosureTask;
use SwitchBall\Main;
use SwitchBall\Utils\SwitchBallManager;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;

class EntityDamageListener implements Listener {

    /**
     * @param EntityDamageEvent  $event
     * @return void
     */
    public function onSwitchBallHit(EntityDamageEvent $event): void {

        $projectile = $event->getChild();
        $damager = $projectile->getOwningEntity();

        if($damager instanceof Player && $projectile instanceof Snowball) {

            $victim = $event->getEntity();

            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($event, $victim, $damager): void {

                $configMessage = Main::$config->get("config-message");

                if($victim instanceof Player && !$event->isCancelled())
                    SwitchBallManager::switchPlayers($damager, $event->getEntity(), $configMessage);
                else
                    $damager->sendPopup($configMessage["cannot-switch"]);

            }), 2);
        }
    }

    /**
     * @param ProjectileLaunchEvent $event
     * @return void
     */
    public function onSwitchBallLaunch(ProjectileLaunchEvent $event): void {

        $projectile = $event->getEntity();
        $player = $projectile->getOwningEntity();

        if(!$player instanceof Player)
            return;

        $itemId = $player->getInventory()->getItemInHand()->getId();

        if($itemId === ItemIds::SNOWBALL) {

            $playerName = $player->getName();

            if (isset(SwitchBallManager::$cooldown[$playerName]) && SwitchBallManager::$cooldown[$playerName] > time()) {

                $player->sendPopup(Main::$config->get("config-message")["cooldown"]);
                $event->cancel();
                return;
            }

            SwitchBallManager::$cooldown[$playerName] = time() + Main::$config->get("config-settings")["cooldown-time"];
        }
    }
}