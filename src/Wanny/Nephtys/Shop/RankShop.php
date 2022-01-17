<?php
namespace Wanny\Nephtys\Shop;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\Forms\element\Dropdown;
use Wanny\Nephtys\Forms\element\Option;
use Wanny\Nephtys\Forms\utils\FormResponse;
use Wanny\Nephtys\Forms\variant\CustomForm;
use Wanny\Nephtys\NephtysPlayer;

class RankShop extends CustomForm{
    const RANKS = ["Scribe", "Vizir", "Pharaon"];
    public function __construct()
    {
        parent::__construct("Acheter un grade");
    }

    protected function onCreation(): void
    {
        $id = 1;
        $dropdown = new Dropdown("Choisissez le grade que vous voulez acheter");
        foreach (self::RANKS as $grade){
            if($id == (count(self::RANKS) + 1)) break;
            $dropdown->addOption(new Option($id, "$grade -> ".$this->getPrice($grade)." money"));
            $id++;
        }
        $this->addElement("dropdown_ranks", $dropdown);
    }

    public function getPrice(string $rank){
        $format = new Config(Core::getInstance()->getDataFolder() . "format.yml", Config::YAML);
        return $format->get("$rank"."_price");
    }

    protected function onSubmit(Player $player, FormResponse $response): void
    {
        $dropdown = $response->getDropdownSubmittedOptionId("dropdown_ranks");

        if ($dropdown == "1") $this->buyRank($player, "Scribe", $this->getPrice("Scribe"));
        if ($dropdown == "2") $this->buyRank($player, "Vizir", $this->getPrice("Vizir"));
        if ($dropdown == "3") $this->buyRank($player, "Pharaon", $this->getPrice("Pharaon"));
    }

    public function buyRank(Player $player, string $rank, int $price){
        $prank = $player->getRank("normal");
        if ($player instanceof NephtysPlayer){
            if (strcmp($prank, $rank) !== 0){
                if ($player->getMoney() >= $price){
                    $player->removeMoney($price);
                    $player->setRank($rank);
                    $player->sendMessage("Vous avez bien acheté le grade $rank");
                } else $player->sendMessage("Vous n'avez pas assez d'argent");
            } else $player->sendMessage("Vous avez déjà le grade");
        }
    }
}