<?php

declare(strict_types=1);


namespace Wanny\Nephtys\Forms\variant;

use pocketmine\form\FormValidationException;
use pocketmine\player\Player;
use Wanny\Nephtys\Forms\element\Button;
use Wanny\Nephtys\Forms\Form;
use Wanny\Nephtys\Forms\utils\Closable;

class SimpleForm extends Form {
    use Closable;

    /** @var Button[] */
    private array $buttons = [];

    private ?string $headerText;

    public function __construct(string $title, ?string $headerText = null) {
        $this->headerText = $headerText;
        parent::__construct($title);
    }

    /**
     * @return Button[]
     */
    public function getButtons(): array {
        return $this->buttons;
    }

    public function addButton(Button $button): void {
        $this->buttons[] = $button;
    }

    public function getHeaderText(): ?string {
        return $this->headerText;
    }

    public function setHeaderText(?string $headerText): void {
        $this->headerText = $headerText;
    }

    protected function getType(): string {
        return Form::TYPE_SIMPLE_FORM;
    }

    public function handleResponse(Player $player, $data): void {
        if($data === null) {
            $this->notifyClose($player);
        } elseif(!is_int($data) or !isset($this->buttons[$data])) {
            throw new FormValidationException( "Couldn't find the option $data");
        } else {
            $this->buttons[$data]->notifySubmit($player);
        }
    }

    public function serializeBody(): array {
        return [
            "buttons" => array_map(function(Button $button) {
                return $button->jsonSerialize();
            }, $this->buttons),
            "content" => $this->headerText ?? ""
        ];
    }

}