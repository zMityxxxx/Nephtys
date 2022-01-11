<?php
namespace Wanny\Nephtys;

use pocketmine\network\SourceInterface;
use pocketmine\Player;
use pocketmine\utils\Config;

class NephtysPlayer extends Player{

    const GRADES = ["Joueur", "Guide", "Moderateur", "Administrateur", "Fondateur"];

    const PVP_GRADE = ["Bronze I", "Bronze II", "Bronze III", "Bronze IV", "Bronze V"];

    public function __construct(SourceInterface $interface, string $ip, int $port)
    {
        parent::__construct($interface, $ip, $port);
    }

    public function getElo(){
        return Core::getInstance()->getProvider()->getElos($this);
    }

    public function addElos(int $elo){
        return Core::getInstance()->getProvider()->addElos($this, $elo);
    }

    public function removeElos(int $elo){
        return Core::getInstance()->getProvider()->removeElos($this, $elo);
    }

    public function setElos(int $elo) {
        return Core::getInstance()->getProvider()->setElos($this, $elo);
    }

    public function create(){
        return Core::getInstance()->getProvider()->createAccount($this);
    }

    public function getRank(string $type) {
        return Core::getInstance()->getProvider()->getRank($this, $type);
    }

    public function setRank(string $rank) {
        return Core::getInstance()->getProvider()->setRank($this, $rank);
    }

    public function addRank(){
        return Core::getInstance()->getProvider()->addPvPRank($this);
    }

    public function getFormat(string $rank) {
        $c = new Config(Core::getInstance()->getDataFolder() . "format.yml", 2);
        return $c->exists($rank) ? $c->get($rank) : null;
    }

    public function getKills() {
        return Core::getInstance()->getProvider()->getKills($this);
    }

    public function getDeaths() {
        return Core::getInstance()->getProvider()->getDeaths($this);
    }

    public function addKill(int $kill) {
        return Core::getInstance()->getProvider()->addKill($this, $kill);
    }

    public function addDeath(int $death) {
        return Core::getInstance()->getProvider()->addDeath($this, $death);
    }

}
