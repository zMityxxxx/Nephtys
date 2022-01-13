<?php
namespace Wanny\Nephtys\Commands\MoneyCmd;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Money extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("money", $core);
        $this->setDescription("Voir votre argent ou celui d'un joueur");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (isset($args[0])){
            $target = $this->core->getServer()->getPlayer($args[0]);
            if ($target instanceof NephtysPlayer){
                $money = $target->getMoney();
                $sender->sendMessage("Le joueur {$sender->getName()} a $money de money");
            } else $sender->sendMessage("Le joueur n'est pas connecté");
        } else{
            if ($sender instanceof NephtysPlayer){
                $money = $sender->getMoney();
                $sender->sendMessage("Vous avez $money de money");
            } else $sender->sendMessage("Usage : /money (joueur)");
        }
    }

}