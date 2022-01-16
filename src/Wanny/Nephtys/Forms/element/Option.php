<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\element;


class Option {

    private string $id;
    private string $text;

    public function __construct(string $id, string $text) {
        $this->id = $id;
        $this->text = $text;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setText(string $text): void {
        $this->text = $text;
    }

}