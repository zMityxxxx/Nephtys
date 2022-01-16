<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Setrank extends Command {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("setrank");
        $this->setDescription("Changer le grade d'un joueur");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if (($sender instanceof NephtysPlayer and !$sender->hasPermission("admin")) or ($sender instanceof NephtysPlayer && !$sender->isOp())){
            $sender->sendMessage("Vous n'avez pas la permssion");
            return false;
        }

        if (isset($args[0])){
            $target = $this->core->getServer()->getPlayerByPrefix($args[0]);
            if ($target instanceof NephtysPlayer){
                if (isset($args[1])){
                    $grade = $args[1];
                    if (in_array($grade, NephtysPlayer::GRADES)){
                        $target->setRank($grade);
                        $c = new Config(Core::getInstance()->getDataFolder() . "format.yml", 2);
                        $permissions = $c->get("permissions")[$grade];
                        foreach ($permissions as $permission) {
                            $attachment = $sender->addAttachment(Core::getInstance());
                            $attachment->setPermission($permission, true);
                            $sender->addAttachment(Core::getInstance(), $permission);
                        }
                    } else $sender->sendMessage("Je ne trouve pas le grade");
                } else $sender->sendMessage("Usage : /setrank (joueur) (grade)");
            } else $sender->sendMessage("Le joueur n'est pas connecté");
        } else $sender->sendMessage("Usage : /setrank (joueur) (grade)");
    }

}