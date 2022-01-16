<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\element;

use Closure;
use Wanny\Nephtys\Forms\icon\ButtonIcon;
use Wanny\Nephtys\Forms\utils\Submittable;
use JsonSerializable;

class Button implements JsonSerializable {
    use Submittable;

    private string $text;
    private ?ButtonIcon $icon;

    public function __construct(string $text, ?ButtonIcon $icon = null, ?Closure $listener = null) {
        $this->text = $text;
        $this->icon = $icon;
        $this->setSubmitListener($listener);
    }

    public function hasIcon(): bool {
        return $this->icon !== null;
    }

    public function getIcon(): ?ButtonIcon {
        return $this->icon;
    }

    public function setIcon(?ButtonIcon $icon): void {
        $this->icon = $icon;
    }

    public function jsonSerialize(): array {
        $data = [
            "text" => $this->text
        ];

        if($this->hasIcon()) {
            $data["image"] = $this->icon->jsonSerialize();
        }

        return $data;
    }

}
