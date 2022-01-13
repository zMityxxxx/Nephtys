<?php
namespace Wanny\Nephtys\utils;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class KitManager {
    public static function sendKit(NephtysPlayer $player, string $type){
        switch ($type){
            case "Joueur":
                $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Joueur.yml",2);
                if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {

                    $casque = Item::get(Item::DIAMOND_HELMET);
                    $casque->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION)));
                    $casque->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING)));
                    $plastron = Item::get(Item::DIAMOND_CHESTPLATE);
                    $plastron->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION)));
                    $plastron->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING)));
                    $jambiere = Item::get(Item::DIAMOND_LEGGINGS);
                    $jambiere->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION)));
                    $jambiere->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING)));
                    $bottes = Item::get(Item::DIAMOND_BOOTS);
                    $bottes->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION)));
                    $bottes->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING)));
                    $epee = Item::get(Item::DIAMOND_SWORD);
                    $epee->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS)));
                    $epee->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING)));
                    $enderpearl = Item::get(Item::ENDER_PEARL, 0, 16);
                    $items = [$casque, $plastron, $jambiere, $bottes, $enderpearl, $epee];
                    foreach ($items as $item) {
                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else $player->getLevel()->dropItem($player->asVector3(), $item);
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
                if ($player->hasPermission("scribe")){
                    $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Scribe.yml",2);
                    if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {

                        $casque = Item::get(Item::DIAMOND_HELMET);
                        $casque->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2));
                        $casque->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 2));
                        $plastron = Item::get(Item::DIAMOND_CHESTPLATE);
                        $plastron->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2));
                        $plastron->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 2));
                        $jambiere = Item::get(Item::DIAMOND_LEGGINGS);
                        $jambiere->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2));
                        $jambiere->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 2));
                        $bottes = Item::get(Item::DIAMOND_BOOTS);
                        $bottes->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2));
                        $bottes->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 2));
                        $epee = Item::get(Item::DIAMOND_SWORD);
                        $epee->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 2));
                        $epee->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 2));
                        $enderpearl = Item::get(Item::ENDER_PEARL, 0, 16);
                        $items = [$casque, $plastron, $jambiere, $bottes, $enderpearl, $epee];
                        foreach ($items as $item) {
                            if ($player->getInventory()->canAddItem($item)) {
                                $player->getInventory()->addItem($item);
                            } else $player->getLevel()->dropItem($player->asVector3(), $item);
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
                if ($player->hasPermission("vizir")){
                    $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Vizir.yml",2);
                    if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {

                        $casque = Item::get(Item::DIAMOND_HELMET);
                        $casque->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3));
                        $casque->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $plastron = Item::get(Item::DIAMOND_CHESTPLATE);
                        $plastron->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3));
                        $plastron->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $jambiere = Item::get(Item::DIAMOND_LEGGINGS);
                        $jambiere->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3));
                        $jambiere->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $bottes = Item::get(Item::DIAMOND_BOOTS);
                        $bottes->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3));
                        $bottes->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $epee = Item::get(Item::DIAMOND_SWORD);
                        $epee->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 3));
                        $epee->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $enderpearl = Item::get(Item::ENDER_PEARL, 0, 16);
                        $items = [$casque, $plastron, $jambiere, $bottes, $enderpearl, $epee];
                        foreach ($items as $item) {
                            if ($player->getInventory()->canAddItem($item)) {
                                $player->getInventory()->addItem($item);
                            } else $player->getLevel()->dropItem($player->asVector3(), $item);
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
                if ($player->hasPermission("pharaon")){
                    $kit = new Config(Core::getInstance()->getDataFolder() . "Kits/Pharaon.yml",2);
                    if (!$kit->exists($player->getName()) or $kit->get($player->getName()) - time() <= 0) {

                        $casque = Item::get(Item::DIAMOND_HELMET);
                        $casque->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                        $casque->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 4));
                        $plastron = Item::get(Item::DIAMOND_CHESTPLATE);
                        $plastron->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                        $plastron->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 4));
                        $jambiere = Item::get(Item::DIAMOND_LEGGINGS);
                        $jambiere->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                        $jambiere->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 4));
                        $bottes = Item::get(Item::DIAMOND_BOOTS);
                        $bottes->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                        $bottes->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 4));
                        $epee = Item::get(Item::DIAMOND_SWORD);
                        $epee->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 4));
                        $epee->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 4));
                        $enderpearl = Item::get(Item::ENDER_PEARL, 0, 16);
                        $items = [$casque, $plastron, $jambiere, $bottes, $enderpearl, $epee];
                        foreach ($items as $item) {
                            if ($player->getInventory()->canAddItem($item)) {
                                $player->getInventory()->addItem($item);
                            } else $player->getLevel()->dropItem($player->asVector3(), $item);
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
                    $array = [Item::get(3, 0, 256), Item::get(17, 0, 64), Item::get(1, 0, 64), Item::get(12, 0, 64), Item::get(155, 0, 64), Item::get(168, 0, 64), Item::get(35, 0, 64), Item::get(236, 0, 64), Item::get(49, 0, 64)];
                    foreach ($array as $item) {
                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else $player->getLevel()->dropItem($player->asVector3(), $item);
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
                $player->getInventory()->addItem(Item::get(Item::SPLASH_POTION, 0, $emptys));
                $player->sendMessage("Vous avez bien reçu votre kit potions ");
                break;
        }
    }

}