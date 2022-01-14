<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Elo extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("elo", $core);
        $this->setDescription("Regarder le nombre d'elo");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof NephtysPlayer) {
            if (isset($args[0])){
                $target = $this->core->getServer()->getPlayer($args[0]);
                if ($target instanceof NephtysPlayer){
                    $sender->sendMessage("{$target->getName()} a {$target->getElo()} elo");
                } else $sender->sendMessage("Le joueur n'est pas connecté");
            } else $sender->sendMessage("Usage /elo (joueur)");
        } else $sender->sendMessage("Vous avez {$sender->getElo()} Elo!");
    }

}