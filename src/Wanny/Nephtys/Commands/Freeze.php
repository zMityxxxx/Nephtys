<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Freeze extends Command {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("freeze");
        $this->setDescription("Freeze un joueur");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (isset($args[0])){
            if ($sender->hasPermission("mod") or ($sender instanceof NephtysPlayer && $sender->isOp()))
            $target = $this->core->getServer()->getPlayerByPrefix($args[0]);
            if ($target instanceof NephtysPlayer){
                if ($target->isFreeze()){
                    $target->setImmobile(false);
                    $target->setFreeze(false);
                    $target->sendMessage("Vous avez été unfreeze!");
                    if (!$target->isFreeze() and !$target->isImmobile()) $sender->sendMessage("Vous avez bien unfreeze {$target->getName()}");
                } else{
                    $target->setImmobile(true);
                    $target->setFreeze(true);
                    $target->sendMessage("Vous avez été freeze!");
                    if ($target->isFreeze() and $target->isImmobile()) $sender->sendMessage("Vous avez bien freeze {$target->getName()}");
                }
            } else $sender->sendMessage("Le joueur n'est pas connecté");
        } else $sender->sendMessage("Usage : /freeze (joueur)");
    }

}