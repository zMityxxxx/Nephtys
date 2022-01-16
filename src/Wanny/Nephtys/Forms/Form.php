<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms;

use pocketmine\form\Form as PmForm;

abstract class Form implements PmForm {

    private string $title;

    public const TYPE_SIMPLE_FORM = "form";
    public const TYPE_CUSTOM_FORM = "custom_form";
    public const TYPE_MODAL_FORM = "modal";

    public function __construct(string $title) {
        $this->title = $title;
        $this->onCreation();
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    abstract protected function getType(): string;

    abstract protected function serializeBody(): array;

    public function jsonSerialize(): array {
        $body = $this->serializeBody();
        $body["title"] = $this->title;
        $body["type"] = $this->getType();
        return $body;
    }

    protected function onCreation(): void {}

}