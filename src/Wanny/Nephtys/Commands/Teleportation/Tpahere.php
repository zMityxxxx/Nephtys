<?php
namespace Wanny\Nephtys\Commands\Teleportation;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Tpahere extends Command {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("tpahere");
        $this->setDescription("Téléportez un joueur à votre position");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer){
            if (isset($args[0])){
                $name = strtolower($args[0]);
                foreach($this->core->getServer()->getOnlinePlayers() as $player){
                    if(strtolower($player->getName()) === $name){
                        $target =  $player;
                        if ($target instanceof NephtysPlayer){
                            if (!$sender->isRequestingTeleport($target)){
                                $sender->addTeleportRequest($target);
                                $sender->sendMessage("Vous avez bien envoyé une demande de téléportation à {$target->getName()}");
                                $target->sendMessage("{$sender->getName()} vient de vous envoyer une demande de téléportation\n/tpaccept : pour accepter\n/tppdeny : pour refuser\nVous avez 30 secondes pour vous décider, bon jeu!");
                            } else $sender->sendMessage("Vous avez déjà envoyé une demande de téléportation à {$target->getName()}");
                        } else $sender->sendMessage("Le joueur n'est pas connecté");
                    }
                }
            } else $sender->sendMessage("Usage : /tpahere (joueur)");
        } else $sender->sendMessage("Utilisez la commande en jeu!");
    }

}
