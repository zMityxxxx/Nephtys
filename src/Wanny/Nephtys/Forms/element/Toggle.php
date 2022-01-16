<?php

declare(strict_types=1);

namespace Wanny\Nephtys\Forms\element;

class Toggle extends Element {

    private bool $defaultChoice;
    private ?bool $submittedChoice = null;

    public function __construct(?string $headerText, bool $defaultChoice = false) {
        $this->defaultChoice = $defaultChoice;
        parent::__construct($headerText);
    }

    public function getSubmittedChoice(): ?bool {
        return $this->submittedChoice;
    }

    public function getType(): string {
        return Element::TYPE_TOGGLE;
    }

    public function getDefaultChoice(): bool {
        return $this->defaultChoice;
    }

    public function setDefaultChoice(bool $defaultChoice): void {
        $this->defaultChoice = $defaultChoice;
    }

    public function assignResult($result): void {
        $this->submittedChoice = $result;
    }

    public function serializeBody(): array {
        return [
            "default" => $this->defaultChoice
        ];
    }

}