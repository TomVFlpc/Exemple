<?php

namespace Slazy\Welcome\Events;

use Slazy\Welcome\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Server;
use pocketmine\utils\Config;

class PlayerQuitEvents implements Listener
{

    public function OnQuit(PlayerQuitEvent $event)
    {

        $config = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);

    $player = $event->getPlayer();
    $event->setQuitMessage(" ");
    $message = str_replace("{player}", $player->getName(), $config->get("Quit"));
    Server::getInstance()->broadcastMessage($message);
    }

}