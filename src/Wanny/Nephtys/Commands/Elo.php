<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Elo extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("elo", $core);
        $this->setDescription("Regarder le nombre d'elo");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer) $sender->sendMessage("Vous avez {$sender->getElo()} Elo!");
    }

}