<?php

namespace SwitchBall\Utils;

use pocketmine\player\Player;
use SwitchBall\Item\SwitchBall;
use SwitchBall\Listener\EntityDamageListener;
use SwitchBall\Main;
use pocketmine\item\ItemFactory;
use pocketmine\utils\Config;

class SwitchBallManager {

    /** @var array */
    public static array $cooldown = [];

    /**
     * @return void
     */
    public static function initConfig(): void {

        if(!file_exists(Main::getInstance()->getDataFolder() . "config-switchball.yml"))
            Main::getInstance()->saveResource("config-switchball.yml");

        Main::$config = new Config(Main::getInstance()->getDataFolder() . "config-switchball.yml", Config::YAML);
    }

    /**
     * @return void
     */
    public static function initRecipe(): void {
        SwitchBallRecipe::initRecipe(Main::getInstance()->getServer()->getCraftingManager());
    }

    /**
     * @return void
     */
    public static function registerItem(): void {
        ItemFactory::getInstance()->register(new SwitchBall(), true);
    }

    /**
     * @return void
     */
    public static function registerEvent(): void {
        $instance = Main::getInstance();
        $instance->getServer()->getPluginManager()->registerEvents(new EntityDamageListener(), $instance);
    }

    /**
     * @param Player $damager
     * @param Player $victim
     * @param array $configMessage
     * @return void
     */
    public static function switchPlayers(Player $damager, Player $victim, array $configMessage): void {

        $victimPos = $victim->getPosition()->asVector3();
        $damagerPos = $damager->getPosition()->asVector3();

        $victim->teleport($damagerPos);
        $damager->teleport($victimPos);

        $damager->sendMessage($configMessage["success-switch"]);
    }
}