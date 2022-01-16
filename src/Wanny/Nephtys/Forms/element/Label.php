<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\element;


class Label extends Element {

    public function __construct(string $headerText) {
        parent::__construct($headerText);
    }

    public function getType(): string {
        return Element::TYPE_LABEL;
    }

    public function assignResult($result): void {
        return;
    }

    public function serializeBody(): array {
        return [];
    }

}