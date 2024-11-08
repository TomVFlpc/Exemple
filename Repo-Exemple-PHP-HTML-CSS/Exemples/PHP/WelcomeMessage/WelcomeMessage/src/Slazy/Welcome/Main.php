<?php

namespace Slazy\Welcome;

use Slazy\Welcome\Events\PlayerJoinEvents;
use Slazy\Welcome\Events\PlayerQuitEvents;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{

    public Config $config;

    private static $instance;

    public function onEnable(): void
    {

        self::$instance = $this;

        $this->getLogger()->info("§f[§l§4WeclomePopup§r§f]: activée");
        $this->saveResource("config.yml");

        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoinEvents(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerQuitEvents(), $this);
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}