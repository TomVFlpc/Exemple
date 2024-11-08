<?php

namespace Slazy\NV\Commands;

use Slazy\NV\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class NightVision extends Command
{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        if($sender instanceof Player){
            if($sender->hasPermission("nv.use")){
                if($sender->getEffects()->has(VanillaEffects::NIGHT_VISION())){
                    $sender->getEffects()->remove(VanillaEffects::NIGHT_VISION());
                    $sender->sendMessage($config->get("EffectSuccesRemove"));
                }else{
                    $sender->getEffects()->add(new EffectInstance(VanillaEffects::NIGHT_VISION(), 999999 , 0 , $config->get("EffectVisibility")));
                    $sender->sendMessage($config->get("EffectSuccesAdd"));
                }

            }else{
                $sender->sendMessage($config->get("NoPermission"));
            }
        }
    }
}