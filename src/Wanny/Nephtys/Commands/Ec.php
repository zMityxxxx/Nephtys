<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Ec extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("ec", $core);
        $this->setAliases(["enderchest"]);
        $this->setDescription("Ouvrir l'enderchest");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer){
            $x = (int)floor($sender->getX());
            $y = (int)floor($sender->getY()) - 3;
            $z = (int)floor($sender->getZ());
            $nbt = new CompoundTag("", [new StringTag("id", Tile::CHEST), new StringTag("CustomName", "EnderChest"), new IntTag("x", $x), new IntTag("y", $y), new IntTag("z", $z)]);
            $tile = Tile::createTile("EnderChest", $sender->getLevel(), $nbt);
            $block = Block::get(BlockIds::ENDER_CHEST); $block->x = (int)$tile->getX(); $block->y = (int)$tile->getY(); $block->z = (int)$tile->getZ();
            $block->level = $tile->getLevel();
            $block->getLevel()->sendBlocks([$sender], [$block]);
            if ($tile instanceof EnderChest) {
                $sender->getEnderChestInventory()->setHolderPosition($tile);
                $sender->addWindow($sender->getEnderChestInventory());
            }
        }
    }

}