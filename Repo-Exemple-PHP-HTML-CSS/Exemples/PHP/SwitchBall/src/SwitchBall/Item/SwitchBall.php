<?php

namespace SwitchBall\Item;

use pocketmine\item\ItemIds;
use pocketmine\item\Snowball;
use SwitchBall\Main;
use pocketmine\item\ItemIdentifier;
use pocketmine\utils\Config;

class SwitchBall extends Snowball {

    /** @var Config */
    public Config $config;

    /** @var array */
    public array $configMessage = [];

    /** @var array */
    public array $configSettings = [];

    /** @var array */
    public array $configPlugin = [];

    public function __construct() {

        $this->config = new Config(Main::getInstance()->getDataFolder() . "config-switchball.yml", Config::YAML);

        $this->configMessage = $this->config->get("config-message");
        $this->configSettings = $this->config->get("config-settings");
        $this->configPlugin = $this->config->get("config-plugin");

        parent::__construct(new ItemIdentifier(ItemIds::SNOWBALL, 0), $this->configPlugin["name"]);
    }

    public function getThrowForce(): float {
        return $this->configPlugin["throw-force"];
    }
}