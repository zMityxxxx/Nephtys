<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\player\Player;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Clear extends VanillaCommand {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("clear");
        $this->setAliases(["clearinv"]);
        $this->setDescription("Clear l'inventaire d'un joueur");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender->hasPermission("admin") or ($sender instanceof NephtysPlayer && $sender->isOp())) {
            if (isset($args[0])) {
                if ($args[0] == "ec") {
                    if (isset($args[1])) {
                        $target = $this->core->getServer()->getPlayerByPrefix($args[1]);
                        if ($target instanceof Player) {
                            $target->getEnderInventory()->clear(true);
                            $sender->sendMessage("Vous avez bien clear l'ec de {$target->getName()}");
                        } else $sender->sendMessage("Le joueur n'est pas connecté");
                    }
                } else {
                    $target = $this->core->getServer()->getPlayerByPrefix($args[0]);
                    if ($target instanceof Player) {
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