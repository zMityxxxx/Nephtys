<?php
namespace Wanny\Nephtys\utils;

use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\utils\Config;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class KitManager {
    public static function sendKit(NephtysPlayer $player, string $type){
        switch ($type){
            case "Joueur":
                $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Joueur.yml",2);
                if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {

                    $casque = ItemFactory::getInstance()->get(ItemIds::DIAMOND_HELMET);
                    $casque->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION()));
                    $casque->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING()));
                    $plastron = ItemFactory::getInstance()->get(ItemIds::DIAMOND_CHESTPLATE);
                    $plastron->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION()));
                    $plastron->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING()));
                    $jambiere = ItemFactory::getInstance()->get(ItemIds::DIAMOND_LEGGINGS);
                    $jambiere->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION()));
                    $jambiere->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING()));
                    $bottes = ItemFactory::getInstance()->get(ItemIds::DIAMOND_BOOTS);
                    $bottes->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION()));
                    $bottes->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING()));
                    $epee = ItemFactory::getInstance()->get(ItemIds::DIAMOND_SWORD);
                    $epee->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS()));
                    $epee->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING()));
                    $enderpearl = ItemFactory::getInstance()->get(ItemIds::ENDER_PEARL, 0, 16);
                    $items = [$casque, $plastron, $jambiere, $bottes, $enderpearl, $epee];
                    foreach ($items as $item) {
                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else{
                            $player->getWorld()->dropItem($player->getPosition(), $item);}
                    }
                    $kit->set($player->getName(), time() + 14400);
                    $kit->save();
                    $player->sendMessage("Vous avez bien reçu votre kit Joueur");

                } else {
                    $results = Utils::traductionTime($kit->get($player->getName()));
                    $hour = $results['hour'];
                    $minute = $results['minute'];
                    $player->sendMessage("Vous devez attendre $hour heure(s) et $minute minute(s)");
                }
                break;
            case "Scribe":
                if ($player->hasPermission("scribe") or $player->isOp()){
                    $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Scribe.yml",2);
                    if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {

                        $casque = ItemFactory::getInstance()->get(ItemIds::DIAMOND_HELMET);
                        $casque->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 2));
                        $casque->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2));
                        $plastron = ItemFactory::getInstance()->get(ItemIds::DIAMOND_CHESTPLATE);
                        $plastron->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 2));
                        $plastron->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2));
                        $jambiere = ItemFactory::getInstance()->get(ItemIds::DIAMOND_LEGGINGS);
                        $jambiere->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 2));
                        $jambiere->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2));
                        $bottes = ItemFactory::getInstance()->get(ItemIds::DIAMOND_BOOTS);
                        $bottes->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 2));
                        $bottes->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2));
                        $epee = ItemFactory::getInstance()->get(ItemIds::DIAMOND_SWORD);
                        $epee->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 2));
                        $epee->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2));
                        $enderpearl = ItemFactory::getInstance()->get(ItemIds::ENDER_PEARL, 0, 16);
                        $items = [$casque, $plastron, $jambiere, $bottes, $epee, $enderpearl];
                        foreach ($items as $item) {
                            if ($player->getInventory()->canAddItem($item)) {
                                $player->getInventory()->addItem($item);
                            } else $player->getWorld()->dropItem($player->getPosition(), $item);
                        }
                        $kit->set($player->getName(), time() + 14400);
                        $kit->save();
                        $player->sendMessage("Vous avez bien reçu votre kit Scribe");

                    } else {
                        $results = Utils::traductionTime($kit->get($player->getName()));
                        $hour = $results['hour'];
                        $minute = $results['minute'];
                        $player->sendMessage("Vous devez attendre $hour heure(s) et $minute minute(s)");
                    }
                } else $player->sendMessage("Vous n'avez pas la permission");
                break;
            case "Vizir":
                if ($player->hasPermission("vizir") or $player->isOp()){
                    $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Vizir.yml",2);
                    if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {

                        $casque = ItemFactory::getInstance()->get(ItemIds::DIAMOND_HELMET);
                        $casque->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 3));
                        $casque->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $plastron = ItemFactory::getInstance()->get(ItemIds::DIAMOND_CHESTPLATE);
                        $plastron->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 3));
                        $plastron->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $jambiere = ItemFactory::getInstance()->get(ItemIds::DIAMOND_LEGGINGS);
                        $jambiere->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 3));
                        $jambiere->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $bottes = ItemFactory::getInstance()->get(ItemIds::DIAMOND_BOOTS);
                        $bottes->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 3));
                        $bottes->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $epee = ItemFactory::getInstance()->get(ItemIds::DIAMOND_SWORD);
                        $epee->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 3));
                        $epee->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $enderpearl = ItemFactory::getInstance()->get(ItemIds::ENDER_PEARL, 0, 16);
                        $items = [$casque, $plastron, $jambiere, $bottes, $epee, $enderpearl];
                        foreach ($items as $item) {
                            if ($player->getInventory()->canAddItem($item)) {
                                $player->getInventory()->addItem($item);
                            } else $player->getWorld()->dropItem($player->getPosition(), $item);
                        }
                        $kit->set($player->getName(), time() + 14400);
                        $kit->save();
                        $player->sendMessage("Vous avez bien reçu votre kit Vizir");

                    } else {
                        $results = Utils::traductionTime($kit->get($player->getName()));
                        $hour = $results['hour'];
                        $minute = $results['minute'];
                        $player->sendMessage("Vous devez attendre $hour heure(s) et $minute minute(s)");
                    }
                } else $player->sendMessage("Vous n'avez pas la permission");
                break;
            case "Pharaon":
                if ($player->hasPermission("pharaon") or $player->isOp()){
                    $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Pharaon.yml",2);
                    if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {

                        $casque = ItemFactory::getInstance()->get(ItemIds::DIAMOND_HELMET);
                        $casque->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
                        $casque->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $plastron = ItemFactory::getInstance()->get(ItemIds::DIAMOND_CHESTPLATE);
                        $plastron->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
                        $plastron->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $jambiere = ItemFactory::getInstance()->get(ItemIds::DIAMOND_LEGGINGS);
                        $jambiere->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
                        $jambiere->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $bottes = ItemFactory::getInstance()->get(ItemIds::DIAMOND_BOOTS);
                        $bottes->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
                        $bottes->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $epee = ItemFactory::getInstance()->get(ItemIds::DIAMOND_SWORD);
                        $epee->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 4));
                        $epee->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                        $enderpearl = ItemFactory::getInstance()->get(ItemIds::ENDER_PEARL, 0, 16);
                        $items = [$casque, $plastron, $jambiere, $bottes, $epee, $enderpearl];
                        foreach ($items as $item) {
                            if ($player->getInventory()->canAddItem($item)) {
                                $player->getInventory()->addItem($item);
                            } else $player->getWorld()->dropItem($player->getPosition(), $item);
                        }
                        $kit->set($player->getName(), time() + 14400);
                        $kit->save();
                        $player->sendMessage("Vous avez bien reçu votre kit Pharaon");

                    } else {
                        $results = Utils::traductionTime($kit->get($player->getName()));
                        $hour = $results['hour'];
                        $minute = $results['minute'];
                        $player->sendMessage("Vous devez attendre $hour heure(s) et $minute minute(s)");
                    }
                } else $player->sendMessage("Vous n'avez pas la permission");
                break;
            case "builder":
                $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Buildeur.yml",2);
                if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {
                    $array = [ItemFactory::getInstance()->get(3, 0, 256), ItemFactory::getInstance()->get(17, 0, 64), ItemFactory::getInstance()->get(1, 0, 64),
                        ItemFactory::getInstance()->get(12, 0, 64), ItemFactory::getInstance()->get(155, 0, 64), ItemFactory::getInstance()->get(168, 0, 64),
                        ItemFactory::getInstance()->get(35, 0, 64), ItemFactory::getInstance()->get(236, 0, 64), ItemFactory::getInstance()->get(49, 0, 64)];
                    foreach ($array as $item) {
                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else $player->getWorld()->dropItem($player->getPosition(), $item);
                    }
                    $kit->set($player->getName(), time() + 14400);
                    $kit->save();
                    $player->sendMessage("Vous avez bien reçu votre kit Buildeur");

                } else {
                    $results = Utils::traductionTime($kit->get($player->getName()));
                    $hour = $results['hour'];
                    $minute = $results['minute'];
                    $player->sendMessage("Vous devez attendre $hour heure(s) et $minute minute(s)");
                }
                break;
            case "potion":
                $emptys = count($player->getInventory()->getContents(true)) - count($player->getInventory()->getContents());
                $player->getInventory()->addItem(ItemFactory::getInstance()->get(ItemIds::SPLASH_POTION, 0, $emptys));
                $player->sendMessage("Vous avez bien reçu votre kit potions ");
                break;
        }
    }

}