<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\tile\EnderChest;
use pocketmine\block\tile\Tile;
use pocketmine\block\tile\TileFactory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\data\bedrock\LegacyItemIdToStringIdMap;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Ec extends Command {
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
        /*
        if ($sender instanceof NephtysPlayer){
            $x = (int)floor($sender->getPosition()->getX());
            $y = (int)floor($sender->getPosition()->getY());
            $z = (int)floor($sender->getPosition()->getZ());
            $nbt = new CompoundTag("", [new StringTag("id", 0), new StringTag("CustomName", "EnderChest"), new IntTag("x", $x), new IntTag("y", $y + 3), new IntTag("z", $z)]);
            $tile = TileFactory::getInstance()->createInventoryAction("EnderChest", $sender->getLevel(), $nbt);
            $block = BlockFactory::getInstance()->get(BlockLegacyIds::ENDER_CHEST); $block->x = (int)$tile->getX(); $block->y = (int)$tile->getY(); $block->z = (int)$tile->getZ();
            $block->x = (int)$tile->getX();
            $block->y = (int)$tile->getY();
            $block->z = (int)$tile->getZ();
            $block->level = $tile->getLevel();
            $block->getWord()->sendBlocks([$sender], [$block]);
            if ($tile instanceof EnderChest) {
                $sender->getEnderInventory()->ge($tile);
                $sender->setCurrentWindow($sender->getEnderInventory());
            }
        }
        */
    }

}