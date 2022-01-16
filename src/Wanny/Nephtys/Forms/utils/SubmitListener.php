<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\utils;


use Closure;
use pocketmine\utils\Utils;
use Wanny\Nephtys\NephtysPlayer;

trait SubmitListener {

    private ?Closure $submitListener = null;

    public function getSubmitListener(): ?Closure {
        return $this->submitListener;
    }

    public function setSubmitListener(?Closure $listener): void {
        if($listener !== null) {
            Utils::validateCallableSignature(function(NephtysPlayer $player) {}, $listener);
        }
        $this->submitListener = $listener;
    }

    public function executeSubmitListener(NephtysPlayer $player): void {
        if($this->submitListener !== null) {
            ($this->submitListener)($player);
        }
    }

}