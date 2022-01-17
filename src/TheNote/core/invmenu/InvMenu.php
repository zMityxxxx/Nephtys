<?php

//   ╔═════╗╔═╗ ╔═╗╔═════╗╔═╗    ╔═╗╔═════╗╔═════╗╔═════╗
//   ╚═╗ ╔═╝║ ║ ║ ║║ ╔═══╝║ ╚═╗  ║ ║║ ╔═╗ ║╚═╗ ╔═╝║ ╔═══╝
//     ║ ║  ║ ╚═╝ ║║ ╚══╗ ║   ╚══╣ ║║ ║ ║ ║  ║ ║  ║ ╚══╗
//     ║ ║  ║ ╔═╗ ║║ ╔══╝ ║ ╠══╗   ║║ ║ ║ ║  ║ ║  ║ ╔══╝
//     ║ ║  ║ ║ ║ ║║ ╚═══╗║ ║  ╚═╗ ║║ ╚═╝ ║  ║ ║  ║ ╚═══╗
//     ╚═╝  ╚═╝ ╚═╝╚═════╝╚═╝    ╚═╝╚═════╝  ╚═╝  ╚═════╝
//   Copyright by TheNote! Not for Resale! Not for others
//

declare(strict_types=1);

namespace TheNote\core\invmenu;

use Closure;
use LogicException;
use TheNote\core\invmenu\inventory\SharedInvMenuSynchronizer;
use TheNote\core\invmenu\session\InvMenuInfo;
use TheNote\core\invmenu\transaction\DeterministicInvMenuTransaction;
use TheNote\core\invmenu\transaction\InvMenuTransaction;
use TheNote\core\invmenu\transaction\InvMenuTransactionResult;
use TheNote\core\invmenu\transaction\SimpleInvMenuTransaction;
use TheNote\core\invmenu\type\InvMenuType;
use TheNote\core\invmenu\type\InvMenuTypeIds;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\inventory\transaction\InventoryTransaction;
use pocketmine\item\Item;
use pocketmine\player\Player;

class InvMenu implements InvMenuTypeIds{

	public static function create(string $identifier, ...$args) : InvMenu{
		return new InvMenu(InvMenuHandler::getTypeRegistry()->get($identifier), ...$args);
	}

	public static function readonly(?Closure $listener = null) : Closure{
		return static function(InvMenuTransaction $transaction) use($listener) : InvMenuTransactionResult{
			$result = $transaction->discard();
			if($listener !== null){
				$listener(new DeterministicInvMenuTransaction($transaction, $result));
			}
			return $result;
		};
	}

	protected InvMenuType $type;
	protected ?string $name = null;
	protected ?Closure $listener = null;
	protected ?Closure $inventory_close_listener = null;
	protected Inventory $inventory;
	protected ?SharedInvMenuSynchronizer $synchronizer = null;

	public function __construct(InvMenuType $type, ?Inventory $custom_inventory = null){
		if(!InvMenuHandler::isRegistered()){
			throw new LogicException("Tried creating menu before calling " . InvMenuHandler::class . "::register()");
		}
		$this->type = $type;
		$this->inventory = $this->type->createInventory();
		$this->setInventory($custom_inventory);
	}

	public function getType() : InvMenuType{
		return $this->type;
	}

	public function getName() : ?string{
		return $this->name;
	}

	public function setName(?string $name) : self{
		$this->name = $name;
		return $this;
	}

	public function setListener(?Closure $listener) : self{
		$this->listener = $listener;
		return $this;
	}

	public function setInventoryCloseListener(?Closure $listener) : self{
		$this->inventory_close_listener = $listener;
		return $this;
	}

	final public function send(Player $player, ?string $name = null, ?Closure $callback = null) : void{
		$session = InvMenuHandler::getPlayerManager()->get($player);
		$network = $session->getNetwork();
		$network->dropPending();

		$player->removeCurrentWindow();

		$network->waitUntil($network->getGraphicWaitDuration(), function(bool $success) use($player, $session, $name, $callback) : void{
			if($success){
				$graphic = $this->type->createGraphic($this, $player);
				if($graphic !== null){
					$graphic->send($player, $name);
					$session->setCurrentMenu(new InvMenuInfo($this, $graphic), $callback);
				}else{
					$session->removeCurrentMenu();
					if($callback !== null){
						$callback(false);
					}
				}
			}elseif($callback !== null){
				$callback(false);
			}
		});
	}

	public function getInventory() : Inventory{
		return $this->inventory;
	}

	public function setInventory(?Inventory $custom_inventory) : void{
		if($this->synchronizer !== null){
			$this->synchronizer->destroy();
			$this->synchronizer = null;
		}

		if($custom_inventory !== null){
			$this->synchronizer = new SharedInvMenuSynchronizer($this, $custom_inventory);
		}
	}

	public function sendInventory(Player $player) : bool{
		return $player->setCurrentWindow($this->getInventory());
	}

	public function handleInventoryTransaction(Player $player, Item $out, Item $in, SlotChangeAction $action, InventoryTransaction $transaction) : InvMenuTransactionResult{
		$inv_menu_txn = new SimpleInvMenuTransaction($player, $out, $in, $action, $transaction);
		return $this->listener !== null ? ($this->listener)($inv_menu_txn) : $inv_menu_txn->continue();
	}

	public function onClose(Player $player) : void{
		if($this->inventory_close_listener !== null){
			($this->inventory_close_listener)($player, $this->getInventory());
		}

		InvMenuHandler::getPlayerManager()->get($player)->removeCurrentMenu();
	}
}
