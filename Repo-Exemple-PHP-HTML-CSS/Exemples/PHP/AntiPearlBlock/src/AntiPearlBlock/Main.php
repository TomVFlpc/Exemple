<?php

namespace AntiPearlBlock;

use AntiPearlBlock\Utils\AntiPearlBlockManager;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    /** @var Main */
    public static Main $main;

    /** @var Config */
    public static Config $config;

    /**
     * @return void
     */
    public function onEnable(): void {

        self::$main = $this;

        AntiPearlBlockManager::initConfig();
        AntiPearlBlockManager::initRecipe();

        AntiPearlBlockManager::registerBlock();
        AntiPearlBlockManager::registerProjectile();
        AntiPearlBlockManager::registerPearl();
        AntiPearlBlockManager::registerItem();

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(self::$config->get("config-message")["enable"]);
    }

    /**
     * @return Main
     */
    public static function getInstance(): Main {
        return self::$main;
    }

    /**
     * @return void
     */
    public function onDisable(): void {
        $this->getLogger()->info(self::$config->get("config-message")["disable"]);
    }
}