<?php

namespace AntiPearlBlock\Block;

use AntiPearlBlock\Main;
use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\utils\Config;

class AntiPearlBlock extends Block {

    /** @var Config */
    public Config $config;

    /** @var array */
    public array $configPlugin = [];

    public function __construct() {

        $this->config = new Config(Main::getInstance()->getDataFolder() . "config-antipearlblock.yml", Config::YAML);

        $this->configPlugin = $this->config->get("config-plugin")["anti-pearl-block"];

        parent::__construct(new BlockIdentifier($this->configPlugin["id"], $this->configPlugin["meta"]), $this->configPlugin["name"], new BlockBreakInfo(3.5, BlockToolType::PICKAXE));
    }
}