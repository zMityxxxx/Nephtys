<?php

declare(strict_types=1);

namespace Wanny\Nephtys\Forms\utils;

use Wanny\Nephtys\NephtysPlayer;

trait Submittable {
    use SubmitListener;

    public function notifySubmit(NephtysPlayer $player): void {
        $this->executeSubmitListener($player);
        $this->onSubmit($player);
    }

    protected function onSubmit(NephtysPlayer $player): void {}

}