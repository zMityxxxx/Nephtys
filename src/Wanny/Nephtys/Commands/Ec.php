<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\block\BlockFactory;
use pocketmine\block\inventory\EnderChestInventory;
use pocketmine\block\tile\EnderChest as TileEnderChest;
use pocketmine\block\tile\TileFactory;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\utils\Config;
use TheNote\core\invmenu\InvMenu;
use TheNote\core\invmenu\transaction\InvMenuTransaction;
use TheNote\core\invmenu\transaction\InvMenuTransactionResult;
use TheNote\core\invmenu\type\InvMenuTypeIds;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;
use pocketmine\block\EnderChest;

class Ec extends Command
{
    private $core;

    public function __construct(Core $core)
    {
        parent::__construct("ec");
        $this->setAliases(["enderchest"]);
        $this->setDescription("Ouvrir l'enderchest");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer) {

            if ($sender->hasPermission("pharaon") or $sender->isOp()) {
                $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
                $menu->setName("Enderchest de {$sender->getName()}");
                $enderchest = $sender->getEnderInventory();
                $item = ItemFactory::getInstance()->get(102, 14)->setCustomName("§cAchetez un slot /boutique");
                $config = new Config(Core::getInstance()->getDataFolder() . "Nephtys/{$sender->getName()}.json", 1);
                $rankslot = NephtysPlayer::ENDER_CHEST_SLOTS[$sender->getRank("normal")] - $config->get("enderchest");

                for ($i = 0; $i <= NephtysPlayer::ENDER_CHEST_SLOTS[$sender->getRank("normal")] - $config->get("enderchest"); ++$i){
                    $enderchest->setItem($i, $item);
                    while($rankslot <= 26){
                        if ($rankslot == 26) break;
                        $ritem = $enderchest->getItem($rankslot);
                        if (!$ritem->getCustomName() === "§cAchetez un slot /boutique") return;
                        $enderchest->setItem($rankslot, ItemFactory::air());
                        $rankslot++;
                    }
                }

                $menu->getInventory()->setContents($enderchest->getContents(true));
                $menu->setListener(function(InvMenuTransaction $transaction) use ($menu, $sender): InvMenuTransactionResult{
                    if($transaction->getItemClicked()->getCustomName() === "§cAchetez un slot /boutique"){
                        if (!$sender->isOp()) return $transaction->discard();
                    }
                    return $transaction->continue();
                });
                $menu->setInventoryCloseListener(function() use($menu, $sender) : void {
                    $sender->getEnderInventory()->setContents($menu->getInventory()->getContents(true));
                });
                $menu->send($sender);

            }

        }
    }
}