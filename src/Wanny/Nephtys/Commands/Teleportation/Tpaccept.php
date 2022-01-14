<?php
namespace Wanny\Nephtys\Commands\Teleportation;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Tpaccept extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("tpaccept", $core);
        $this->setDescription("Accepter une demande de téléportation");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer){

        }
    }
}