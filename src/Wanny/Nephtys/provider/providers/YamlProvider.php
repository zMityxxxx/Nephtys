<?php
namespace Wanny\Nephtys\provider\providers;

use pocketmine\Player;
use pocketmine\utils\Config;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;
use Wanny\Nephtys\provider\ProviderInterface;

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

    public function createAccount(Player $player)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        if (!$this->exists($player)){
            $nephtys->set("elo", 0);
            $nephtys->set("rank", [NephtysPlayer::GRADES[0], NephtysPlayer::PVP_GRADE[0]]);
            $nephtys->set("kill", 0);
            $nephtys->set("death", 0);
            $nephtys->save();
        }
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
        switch ($type){
            case "normal":
                return $nephtys->exists("rank") ? $nephtys->get("rank")[0] : null;
            case "pvp":
                return $nephtys->exists("rank") ? $nephtys->get("rank")[1] : null;
            default:
                return "Mettez un bon type";
        }
    }

    public function setRank(Player $player, string $rank)
    {
        $nephtys = new Config($this->core->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set('rank', [$rank, $this->getRank($player, 'pvp')]);
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
}
