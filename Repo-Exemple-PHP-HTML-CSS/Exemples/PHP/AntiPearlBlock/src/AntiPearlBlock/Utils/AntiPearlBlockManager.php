<?php

namespace AntiPearlBlock\Utils;

use AntiPearlBlock\Block\AntiPearlBlock;
use AntiPearlBlock\Custom\EnderPearlItem;
use AntiPearlBlock\Custom\EnderPearlEntity;
use AntiPearlBlock\Custom\EnderPearlProjectile;
use AntiPearlBlock\Main;
use pocketmine\block\BlockFactory;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\world\World;

class AntiPearlBlockManager {

    /**
     * @return void
     */
    public static function initConfig(): void {

        if(!file_exists(Main::getInstance()->getDataFolder() . "config-antipearlblock.yml"))
            Main::getInstance()->saveResource("config-antipearlblock.yml");

        Main::$config = new Config(Main::getInstance()->getDataFolder() . "config-antipearlblock.yml", Config::YAML);
    }

    /**
     * @return void
     */
    public static function initRecipe(): void {
        AntiPearlBlockRecipe::initRecipe(Main::getInstance()->getServer()->getCraftingManager());
    }

    /**
     * @return void
     */
    public static function registerBlock(): void {
        BlockFactory::getInstance()->register(new AntiPearlBlock(), true);
    }

    /**
     * @return void
     */
    public static function registerProjectile(): void {
        $enderPearlConfig = Main::$config->get("config-plugin")["ender-pearl"];
        ItemFactory::getInstance()->register(new EnderPearlProjectile(new ItemIdentifier(ItemIds::ENDER_PEARL, $enderPearlConfig["meta"]), $enderPearlConfig["name"]), true);
    }

    /**
     * @return void
     */
    public static function registerItem(): void {
        ItemFactory::getInstance()->register(new EnderPearlItem(), true);
    }

    /**
     * @return void
     */
    public static function registerPearl(): void {

        EntityFactory::getInstance()->register(EnderPearlEntity::class, function(World $world, CompoundTag $nbt): EnderPearlEntity {
            return new EnderPearlEntity(EntityDataHelper::parseLocation($nbt, $world), null, $nbt);
        }, ['ThrownEnderpearl', 'minecraft:ender_pearl'], EntityLegacyIds::ENDER_PEARL);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function givePearlBack(Player $player): void {

        if(Main::$config->get("config-settings")["give-pearl"]) {

            $playerInventory = $player->getInventory();

            $playerInventory->addItem(ItemFactory::getInstance()->get(ItemIds::ENDER_PEARL, 0));
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendCancelMessage(Player $player): void {

        $settings = Main::$config->get("config-settings");

        if($settings["message-type"] === "message")
            $player->sendMessage(Main::$config->get("config-message")["cancel"]);
        else
            $player->sendPopup(Main::$config->get("config-message")["cancel"]);

    }
}