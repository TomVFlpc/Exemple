<?php

namespace AntiPearlBlock\Utils;

use pocketmine\crafting\CraftingManager;
use pocketmine\crafting\ShapedRecipe;
use pocketmine\item\ItemFactory;
use AntiPearlBlock\Main;

class AntiPearlBlockRecipe {

    /**
     * @param CraftingManager $craftingManager
     * @return void
     */
    public static function initRecipe(CraftingManager $craftingManager): void {

        $configPlugin = Main::$config->get("config-plugin")["anti-pearl-block"];
        $configCraft = $configPlugin["craft"];

        $item = ItemFactory::getInstance()->get($configPlugin["id"], $configPlugin["meta"], $configPlugin["craft-quantity"])->setCustomName($configPlugin["name"]);

        $craft = new ShapedRecipe([
            "ABC",
            "DEF",
            "GHI",
        ], [
            "A" => ItemFactory::getInstance()->get($configCraft[0][0]),
            "B" => ItemFactory::getInstance()->get($configCraft[0][1]),
            "C" => ItemFactory::getInstance()->get($configCraft[0][2]),
            "D" => ItemFactory::getInstance()->get($configCraft[1][0]),
            "E" => ItemFactory::getInstance()->get($configCraft[1][1]),
            "F" => ItemFactory::getInstance()->get($configCraft[1][2]),
            "G" => ItemFactory::getInstance()->get($configCraft[2][0]),
            "H" => ItemFactory::getInstance()->get($configCraft[2][1]),
            "I" => ItemFactory::getInstance()->get($configCraft[2][2]),
        ], [
            $item
        ]);

        $craftingManager->registerShapedRecipe($craft);
    }
}