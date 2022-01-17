<?php
namespace Wanny\Nephtys\Listener;

use pocketmine\block\inventory\EnderChestInventory;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Server;
use pocketmine\utils\Config;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class EcListener implements Listener
{
    private $core;

    public function __construct(Core $core)
    {
        $this->core = $core;
    }


    public function onOpenEnderchest(InventoryOpenEvent $e): void
    {
        $inv = $e->getInventory();
        $player = $e->getPlayer();
        if (!$player instanceof NephtysPlayer) return;

        if ($inv instanceof EnderChestInventory) {
            $this->setSlots($player);
        }
    }

    public function onEnderchestTransaction(InventoryTransactionEvent $event): void
    {

        $transactions = $event->getTransaction()->getActions();
        if ($player = $event->getTransaction()->getSource()){
            if (Server::getInstance()->isOp($player->getName())) return;
        }

        foreach ($transactions as  $transaction){
            $item = $transaction->getTargetItem();
            if($item->getCustomName() === "§cAchetez un slot /boutique") $event->cancel();
        }

    }

    private function setSlots(NephtysPlayer $player): void
    {
        $enderchest = $player->getEnderInventory();
        $item = ItemFactory::getInstance()->get(102, 14)->setCustomName("§cAchetez un slot /boutique");
        $config = new Config(Core::getInstance()->getDataFolder() . "Nephtys/{$player->getName()}.json", 1);
        $rankslot = NephtysPlayer::ENDER_CHEST_SLOTS[$player->getRank("normal")] - $config->get("enderchest");

        for ($i = 0; $i <= NephtysPlayer::ENDER_CHEST_SLOTS[$player->getRank("normal")] - $config->get("enderchest"); ++$i){
            $enderchest->setItem($i, $item);
            while($rankslot <= 26){
                if ($rankslot == 26) break;
                $ritem = $enderchest->getItem($rankslot);
                if (!$ritem->getCustomName() === "§cAchetez un slot /boutique") return;
                $enderchest->setItem($rankslot, ItemFactory::air());
                $rankslot++;
            }
        }

    }

}