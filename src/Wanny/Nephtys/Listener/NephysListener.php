<?php
namespace Wanny\Nephtys\provider\providers;

use pocketmine\Player;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\provider\ProviderInterface;

class SQLiteProvider implements ProviderInterface {

    private $core;

    public function __construct(Core $core)
    {
        $this->core = $core;
    }

    public function prepare()
    {
        return new \mysqli($this->core->getConfig()->get("hostname"), $this->core->getConfig()->get("username"), $this->core->getConfig()->get("password"), $this->core->getConfig()->get("database"));
    }

    public function exists(Player $player)
    {
        // TODO: Implement exists() method.
    }

    public function createAccount(Player $player)
    {
        // TODO: Implement createAccount() method.
    }

    public function setElos(Player $player, int $elo)
    {
        // TODO: Implement setElos() method.
    }

    public function getElos(Player $player)
    {
        // TODO: Implement getElos() method.
    }

    public function addElos(Player $player, int $elo)
    {
        // TODO: Implement addElos() method.
    }

    public function removeElos(Player $player, int $elo)
    {
        // TODO: Implement removeElos() method.
    }

    public function getRank(Player $player, string $type)
    {
        // TODO: Implement getRank() method.
    }

    public function setRank(Player $player, string $rank)
    {
        // TODO: Implement setRank() method.
    }

    public function getKills(Player $player)
    {
        // TODO: Implement getKills() method.
    }

    public function getDeaths(Player $player)
    {
        // TODO: Implement getDeaths() method.
    }

    public function addKill(Player $player, int $kill)
    {
        // TODO: Implement addKill() method.
    }

    public function addDeath(Player $player, int $death)
    {
        // TODO: Implement removeKill() method.
    }

    public function addPvPRank(Player $player)
    {
        // TODO: Implement addPvPRank() method.
    }

    public function getMoney(Player $player)
    {
        // TODO: Implement getMoney() method.
    }

    public function addMoney(Player $player, int $money)
    {
        // TODO: Implement addMoney() method.
    }

    public function removeMoney(Player $player, int $money)
    {
        // TODO: Implement removeMoney() method.
    }

    public function setMoney(Player $player, int $money)
    {
        // TODO: Implement setMoney() method.
    }
}
