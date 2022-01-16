<?php
namespace Wanny\Nephtys\Commands\Teleportation;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Tpaccept extends Command {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("tpaccept");
        $this->setDescription("Accepter une demande de téléportation");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer){
            if (isset($args[0])){
                $target = $this->core->getServer()->getPlayerByPrefix($args[0]);
                if ($target instanceof NephtysPlayer){
                    if ($target->isRequestingTeleport($sender)){
                        $target->removeTeleportRequest($sender);
                        $sender->teleport($target->getPosition());
                        $sender->sendMessage("Vous avez accepté la demande de {$target->getName()}");
                        $target->sendMessage("{$sender->getName()} a bien accepté la demande de téléportation");
                    } else $sender->sendMessage("Vous n'avez aucune demande de téléportation de la part de {$sender->getName()}");
                } else $sender->sendMessage("Le joueur n'est pas connecté");
            } else $sender->sendMessage("Usage : /tpaccept (joueur)");
        } else $sender->sendMessage("Utilisez la commande en jeu");
    }
}