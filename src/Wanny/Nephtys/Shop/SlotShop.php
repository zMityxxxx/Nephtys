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

class SlotShop extends CustomForm {
    public function __construct()
    {
        parent::__construct("Slot d'EC");
    }

    protected function onCreation(): void
    {
        $dropdown = new Dropdown("Combien de slot voulez-vous acheter");
        $options = [new Option("1_slot", "1"), new Option("2_slot", "2"), new Option("3_slot", "3")];
        foreach ($options as $option) $dropdown->addOption($option);
        $this->addElement("slot_drop", $dropdown);
    }

    protected function onSubmit(Player $player, FormResponse $response): void
    {
        $drop = $response->getDropdownSubmittedOptionId("slot_drop");
        if ($drop == "1_slot") $this->buySlot($player, 1);
        if ($drop == "2_slot") $this->buySlot($player, 2);
        if ($drop == "3_slot") $this->buySlot($player, 3);
    }

    public function buySlot(Player $player, int $number){
        $nephtys = new Config(Core::getInstance()->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $nephtys->set("enderchest", $nephtys->get("enderchest") + $number); $nephtys->save();
        if($player instanceof NephtysPlayer) {
            $count = $player->getEnderInventory()->getSize() - (NephtysPlayer::ENDER_CHEST_SLOTS[$player->getRank("normal")] - $nephtys->get("enderchest")) + 1;
            $player->sendMessage("Vous avez désormais $count places libres dans votre invenaire");
        }
    }

}