<?php

namespace Slazy\XYZ\Tasks;

use Slazy\XYZ\Main;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use Slazy\XYZ\Commands\xyz;
use pocketmine\Server;
use pocketmine\utils\Config;

class XYZTasks extends Task
{

    public function onRun(): void
    {
        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        if(empty(XYZ::$xyz))return;
        foreach (XYZ::$xyz as $player){
            $player = Server::getInstance()->getPlayerExact($player);
            if(is_null($player))continue;
            if($player instanceof Player){
                if($player->isOnline()){
                    $pos = $player->getPosition();
                    $message = str_replace(["{x}", "{y}", "{z}", "{world}"], [$pos->getFloorX(), $pos->getFloorY(),$pos->getFloorZ(), $pos->getWorld()->getFolderName()], $config->get("popup"));
                    $player->sendPopup($message);
                }
            }
        }
    }
}