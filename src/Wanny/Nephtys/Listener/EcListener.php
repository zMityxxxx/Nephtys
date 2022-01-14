<?php
namespace Wanny\Nephtys\Listener;

use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\EnderChestInventory;
use pocketmine\item\Item;
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

        foreach ($transactions as  $transaction){
            $item = $transaction->getTargetItem();
            if($item->getCustomName() === "§cAchetez un slot /boutique") $event->setCancelled();
        }
    }

    private function setSlots(NephtysPlayer $player): void
    {
        $enderchest = $player->getEnderChestInventory();
        $slots = 26 - $player->getEcSlots();

        for ($i = 1; $i <= 26; $i++) {
            if ($slots <= $i) {
                $item = Item::get(102, 14)->setCustomName("§cAchetez un slot /boutique");
                $enderchest->setItem($i, $item);
                $slots++;
            }
        }
    }
}