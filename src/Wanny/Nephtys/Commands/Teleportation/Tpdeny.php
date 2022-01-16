<?php
namespace Wanny\Nephtys\Commands\Teleportation;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Tpdeny extends Command {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("tpdeny");
        $this->setDescription("Refuser une demande de téléportation");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer){

        }
    }
}