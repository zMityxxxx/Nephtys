<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Stats extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("stats", $core);
        $this->setDescription("Voir les statistiques d'un joueur");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer){
            $msg = "{$sender->getName()}:\nkill : {$sender->getKills()}\ndeath : {$sender->getDeaths()}\nelo : {$sender->getElo()}\nGrade : {$sender->getRank('normal')}\nRang : {$sender->getRank('pvp')}\nBon jeu!";
            $sender->sendMessage($msg);
        }
    }

}