<?php

namespace AntiPearlBlock\Custom;

use AntiPearlBlock\Main;
use AntiPearlBlock\Utils\AntiPearlBlockManager;
use pocketmine\block\Block;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class EnderPearlItem extends EnderPearlProjectile {

    /** @var array */
    public static array $cooldown = [];

    public function __construct() {

        $enderPearlConfig = Main::$config->get("config-plugin")["ender-pearl"];

        parent::__construct(new ItemIdentifier(ItemIds::ENDER_PEARL, $enderPearlConfig["meta"]), $enderPearlConfig["name"]);
    }

    public function onInteractBlock(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector): ItemUseResult {

        if($blockClicked->getId() === Main::$config->get("config-plugin")["anti-pearl-block"]["id"]) {

            AntiPearlBlockManager::sendCancelMessage($player);
            return ItemUseResult::FAIL();
        }

        return ItemUseResult::SUCCESS();
    }

    public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult {

        $settings = Main::$config->get("config-settings");
        $playerName = $player->getName();

        if(isset(self::$cooldown[$playerName]) && self::$cooldown[$playerName] > time()) {

            $player->sendPopup(str_replace("{cooldown}", self::$cooldown[$playerName] - time(), Main::$config->get("config-message")["cooldown"]));
            return ItemUseResult::FAIL();
        }

        self::$cooldown[$playerName] = time() + $settings["cooldown-pearl"];
        parent::onClickAir($player, $directionVector);
        return ItemUseResult::SUCCESS();
    }
}