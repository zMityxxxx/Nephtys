<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use Wanny\Nephtys\Core;

class Clear extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("clear", $core);
        $this->setDescription("Clear l'inventaire d'un joueur");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender->hasPermission("admin")){
            if (isset($args[0])){
                if ($args[0] == "ec") {
                    if (isset($args[1])){
                        $target = $this->core->getServer()->getPlayer($args[1]);
                        if ($target instanceof Player){
                            $target->getEnderChestInventory()->clear(true);
                            $sender->sendMessage("Vous avez bien clear l'ec de {$target->getName()}");
                        } else $sender->sendMessage("Le joueur n'est pas connecté");
                    }
                } else {
                    $target = $this->core->getServer()->getPlayer($args[0]);
                    if ($target instanceof Player){
                        $target->getInventory()->clear(true);
                        $target->getArmorInventory()->clear(true);
                        $sender->sendMessage("Vous avez bien clear {$target->getName()}");
                    } else $sender->sendMessage("Le joueur n'est pas connecté");
                }
            } else {
                if ($sender instanceof Player) {
                    $sender->getInventory()->clear(true);
                    $sender->getArmorInventory()->clear(true);
                    $sender->sendMessage("Vous avez bien clear votre inventaire");
                } else $sender->sendMessage("Utilisez la commande en jeu");
            }
        } else $sender->sendMessage("Vous n'avez pas la permission");
    }

}