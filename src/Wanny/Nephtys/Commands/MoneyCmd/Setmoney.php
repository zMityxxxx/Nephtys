<?php
namespace Wanny\Nephtys\Commands\MoneyCmd;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Setmoney extends Command {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("setmoney");
        $this->setDescription("Redéfinir la money d'un joueur");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if ($sender instanceof NephtysPlayer and !$sender->hasPermission("admin")){
            $sender->sendMessage("Vous n'avez pas la permssion");
            return false;
        }

        if (isset($args[0])){
            $target = $this->core->getServer()->getPlayerByPrefix($args[0]);
            if ($target instanceof NephtysPlayer){
                if (isset($args[1])){
                    if (is_numeric($money = $args[1])){
                        $target->setMoney($money);
                        $sender->sendMessage("{$target->getName()} a désormais $money de money");
                    } else $sender->sendMessage("La valeur (money) doit être numérique !");
                } else $sender->sendMessage("Usage : /setmoney (joueur) (money)");
            } else $sender->sendMessage("Le joueur n'est pas connecté");
        } else $sender->sendMessage("Usage : /setmoney (joueur) (money)");
    }

}