<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\utils;

use Wanny\Nephtys\NephtysPlayer;

trait Closable {
    use CloseListener;

    public function notifyClose(NephtysPlayer $player): void {
        $this->executeCloseListener($player);
        $this->onClose($player);
    }

    protected function onClose(NephtysPlayer $player): void {}

}