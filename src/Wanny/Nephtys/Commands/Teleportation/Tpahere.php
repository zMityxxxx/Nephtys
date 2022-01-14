<?php
namespace Wanny\Nephtys\Commands\Teleportation;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Tpahere extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("tpahere", $core);
        $this->setDescription("Téléportez un joueur à votre position");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer){
            if (isset($args[0])){
                $target = $this->core->getServer()->getPlayer($args(0));
                if ($target instanceof NephtysPlayer){

                }
            }
        }
    }

}
