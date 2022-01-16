<?php

declare(strict_types=1);

namespace Wanny\Nephtys\Forms\element;

class StepSlider extends Selector {

    public function getType(): string {
        return Element::TYPE_STEP_SLIDER;
    }

    public function serializeBody(): array {
        return [
            "steps" => $this->getOptionsTexts(),
            "default" => $this->getDefaultIndex()
        ];
    }

}