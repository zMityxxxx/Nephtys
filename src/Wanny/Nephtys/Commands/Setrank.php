<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Setrank extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("setrank", $core);
        $this->setDescription("Changer le grade d'un joueur");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (isset($args[0])){
            $target = $this->core->getServer()->getPlayer($args[0]);
            if ($target instanceof NephtysPlayer){
                if (isset($args[1])){
                    $grade = $args[1];
                    if (in_array($grade, NephtysPlayer::GRADES)){
                        $target->setRank($grade);
                    } else $sender->sendMessage("Je ne trouve pas le grade");
                } else $sender->sendMessage("Usage : /setrank (joueur) (grade)");
            } else $sender->sendMessage("Le joueur n'est pas connecté");
        } else $sender->sendMessage("Usage : /setrank (joueur) (grade)");
    }

}
