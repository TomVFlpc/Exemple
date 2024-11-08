<?php

namespace Slazy\NV;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{
    public Config $config;

    /**
     * @var Main
     */
    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getLogger()->info("§f[§l§4Night Vision§r§f]: Activée");
        $this->saveResource("config.yml");

        $this->getServer()->getCommandMap()->registerAll("all", [
            new Commands\NightVision(name: "nightvision", description: "permet de ce donner un effect de vision nocturne", usageMessage: "nightvision", aliases: ["visionnocturne", "nv"])
        ]);
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}