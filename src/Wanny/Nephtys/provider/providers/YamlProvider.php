<?php
namespace Wanny\Nephtys\provider\providers;

use pocketmine\utils\Config;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;
use Wanny\Nephtys\provider\ProviderInterface;
use Wanny\Nephtys\utils\Utils;
use pocketmine\player\Player;

class YamlProvider implements ProviderInterface{

    private $core;

    public function __construct(Core $core)
    {
        $this->core = $core;
    }

    public function prepare()
    {
        if (!is_dir($this->core->getDataFolder() . "Nephtys/")){
            mkdir($this->core->getDataFolder() . "Nephtys/");
        }
    }

    public function exists(Player $player)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        return ($nephtys->exists($player->getName()));
    }

    /**
     * @throws \JsonException
     */
    public function createAccount(Player $player)
    {

        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        //if (!$this->exists($player)){
        if(!$nephtys->exists("elo")) $nephtys->set("elo", NephtysPlayer::ELO_BASE);
        if(!$nephtys->exists("rank")) $nephtys->set("rank", [NephtysPlayer::GRADES[0], NephtysPlayer::PVP_GRADE[0]]);
        if(!$nephtys->exists("kill")) $nephtys->set("kill", 0);
        if(!$nephtys->exists("death")) $nephtys->set("death", 0);
        if(!$nephtys->exists("money")) $nephtys->set("money", NephtysPlayer::MONEY_BASE);
        if(!$nephtys->exists("enderchest")) $nephtys->set("enderchest", 0);
        $nephtys->save();
        //}

    }

    public function getElos(Player $player)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        return $nephtys->exists("elo") ? $nephtys->get("elo") : null;
    }

    public function addElos(Player $player, int $elo)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("elo", $this->getElos($player) + $elo);
        $nephtys->save();
    }

    public function removeElos(Player $player, int $elo)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("elo", $this->getElos($player) - $elo);
        $nephtys->save();
    }

    public function setElos(Player $player, int $elo)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("elo", $elo);
        $nephtys->save();
    }

    public function getRank(Player $player, string $type)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        return match ($type) {
            "normal" => $nephtys->exists("rank") ? $nephtys->get("rank")[0] : null,
            "pvp" => $nephtys->exists("rank") ? $nephtys->get("rank")[1] : null,
            default => "Mettez un bon type",
        };
    }

    public function setRank(Player $player, string $rank)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set('rank', [$rank, $this->getRank($player, 'pvp')]);
        if ($player instanceof NephtysPlayer)
            Utils::savePlayerPermissions($player);

        $nephtys->save();
    }

    public function addPvPRank(Player $player)
    {
        $rank = $this->getRank($player, 'pvp');
        $key = array_search($rank, NephtysPlayer::PVP_GRADE);
        $newrank = NephtysPlayer::PVP_GRADE[$key + 1];
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("rank", [$this->getRank($player, 'normal'), $newrank]);
        $nephtys->save();
    }

    public function getKills(Player $player)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        return $nephtys->exists("kill") ? $nephtys->get("kill") : null;
    }

    public function getDeaths(Player $player)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        return $nephtys->exists("death") ? $nephtys->get("death") : null;
    }

    public function addKill(Player $player, int $kill)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("kill", $this->getKills($player) + $kill);
        $nephtys->save();
    }

    public function addDeath(Player $player, int $death)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("death", $this->getDeaths($player) + $death);
        $nephtys->save();
    }

    public function getMoney(Player $player)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        return $nephtys->exists("money") ? $nephtys->get("money") : NephtysPlayer::MONEY_BASE;
    }

    public function addMoney(Player $player, int $money)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("money", $this->getMoney($player) + $money);
        $nephtys->save();
    }

    public function removeMoney(Player $player, int $money)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("money", $this->getMoney($player) - $money);
        $nephtys->save();
    }

    public function setMoney(Player $player, int $money)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("money", $money);
        $nephtys->save();
    }
}