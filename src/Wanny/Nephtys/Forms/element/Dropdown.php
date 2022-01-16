<?php

declare(strict_types=1);

namespace Wanny\Nephtys\Forms\element;

class Dropdown extends Selector {

    public function getType(): string {
        return Element::TYPE_DROPDOWN;
    }

    public function serializeBody(): array {
        return [
            "options" => $this->getOptionsTexts(),
            "default" => $this->getDefaultIndex()
        ];
    }

}