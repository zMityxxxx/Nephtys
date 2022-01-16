<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\utils;


use Closure;
use pocketmine\utils\Utils;
use Wanny\Nephtys\NephtysPlayer;

trait CloseListener {

    private ?Closure $closeListener = null;

    public function getCloseListener(): ?Closure {
        return $this->closeListener;
    }

    public function setCloseListener(?Closure $listener): void {
        if($listener !== null) {
            Utils::validateCallableSignature(function(NephtysPlayer $player) {}, $listener);
        }
        $this->closeListener = $listener;
    }

    public function executeCloseListener(NephtysPlayer $player): void {
        if($this->closeListener !== null) {
            ($this->closeListener)($player);
        }
    }

}