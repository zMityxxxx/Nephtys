<?php
namespace Wanny\Nephtys;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class NephtysPlayer extends Player {

    const GRADES = ["Joueur", "Scribe", "Vizir", "Pharaon", "Guide", "Moderateur", "Administrateur", "Fondateur"];

    const PVP_GRADE = ["Bronze I", "Bronze II", "Bronze III", "Bronze IV", "Bronze V"];
    const MONEY_BASE = 0;
    const ELO_BASE = 0;
    const ENDER_CHEST_SLOTS = [
      "Joueur" => 5,
        "Scribe" => 8,
          "Vizir" => 10,
            "Pharaon" => 12,
              "Guide" => 12,
                "Moderateur" => 12,
                  "Administrateur" => 12,
                    "Fondateur" => 12
    ];

    private $teleportRequests = [];
    protected $freeze = false;
    protected $tp = false;

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

    public function getMoney(){
        return Core::getInstance()->getProvider()->getMoney($this);
    }

    public function addMoney(int $money){
        return Core::getInstance()->getProvider()->addMoney($this, $money);
    }

    public function removeMoney(int $money){
        return Core::getInstance()->getProvider()->removeMoney($this, $money);
    }

    public function setMoney(int $money){
        return Core::getInstance()->getProvider()->setMoney($this, $money);
    }

    public function getEcSlots(){
        return Core::getInstance()->getProvider()->getEcSlots($this);
    }

    public function isFreeze(){
        return $this->freeze !== false;
    }

    public function setFreeze(bool $value){
        return $this->freeze = $value;
    }

    public  function isRequestingTeleport(NephtysPlayer $player): bool {
        return isset($this->teleportRequests[$player->getName()]) and ($this->teleportRequests[$player->getName()] - time()) <= 0;
    }

    public function addTeleportRequest(NephtysPlayer $player): void {
        $this->teleportRequests[$player->getName()] = time() + 30;
    }

    public function removeTeleportRequest(NephtysPlayer $player) : void {
        if (isset($this->teleportRequests[$player->getName()])) unset($this->teleportRequests[$player->getName()]);
    }

    public function isOp(): bool {
        return Server::getInstance()->isOp($this->getName());
    }

}