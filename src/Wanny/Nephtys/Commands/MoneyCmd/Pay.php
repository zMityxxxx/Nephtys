<?php
namespace Wanny\Nephtys\Commands\MoneyCmd;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Pay extends PluginCommand {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("pay", $core);
        $this->setDescription('Payer un joueur');
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (isset($args[0])){
            if ($sender instanceof NephtysPlayer){
                $target = $this->core->getServer()->getPlayer($args[0]);
                if ($target instanceof NephtysPlayer){
                    if (isset($args[1])){
                        if (is_numeric($money = $args[1])){
                            if ($sender->getMoney() >= $money){
                                $target->addMoney($money);
                                $sender->removeMoney($money);
                                $sender->sendMessage("{$target->getName()} a bien reçu $money de money");
                                $target->sendMessage("{$target->getName()} vous a envoyé $money de money");
                            } else $sender->sendMessage("Vous n'avez pas la money!");
                        } else $sender->sendMessage("La valeur (money) doit être numérique !");
                    } else $sender->sendMessage("Usage : /pay (joueur) (money)");
                } else $sender->sendMessage("Le joueur n'est pas connecté");
            } else $sender->sendMessage("Utilisez la commande en jeu");
        } else $sender->sendMessage("Usage : /pay (joueur) (money)");
    }

}
