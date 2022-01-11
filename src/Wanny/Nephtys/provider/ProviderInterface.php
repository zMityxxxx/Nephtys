<?php
namespace Wanny\Nephtys\provider;

use pocketmine\Player;
use Wanny\Nephtys\Core;

interface ProviderInterface{

    public function __construct(Core $core);

    public function prepare();

    public function exists(Player $player);

    public function createAccount(Player $player);

    public function setElos(Player $player, int $elo);

    public function getElos(Player $player);

    public function addElos(Player $player, int $elo);

    public function removeElos(Player $player, int $elo);

    public function getRank(Player $player, string $type);

    public function setRank(Player $player, string $type ,string $rank);

    public function getKills(Player $player);

    public function getDeaths(Player $player);

    public function addKill(Player $player, int $kill);

    public function addDeath(Player $player, int $death);

}