<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\element;


use Wanny\Nephtys\Forms\utils\Submittable;

class ModalOption {
    use Submittable;

    private string $text;

    public function __construct(string $text) {
        $this->text = $text;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setText(string $text): void {
        $this->text = $text;
    }

}