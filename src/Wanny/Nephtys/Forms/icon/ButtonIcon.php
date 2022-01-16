<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\icon;


use JsonSerializable;

class ButtonIcon implements JsonSerializable {

    private string $address;
    private string $type;

    public const TYPE_PATH = "path";
    public const TYPE_URL = "url";

    public function __construct(string $address, string $type = self::TYPE_URL) {
        $this->address = $address;
        $this->type = $type;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getType(): string {
        return $this->type;
    }

    public function jsonSerialize(): array {
        return [
            "type" => $this->type,
            "data" => $this->address
        ];
    }
}