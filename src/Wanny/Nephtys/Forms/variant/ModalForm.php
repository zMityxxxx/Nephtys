<?php

declare(strict_types=1);

namespace Wanny\Nephtys\Forms\variant;

use Closure;
use pocketmine\form\FormValidationException;
use Wanny\Nephtys\Forms\Form;
use Wanny\Nephtys\Forms\element\ModalOption;
use pocketmine\player\Player;

class ModalForm extends Form {

    private string $contentText;

    private ModalOption $acceptOption;
    private ModalOption $denyOption;

    public function __construct(string $title, string $contentText, ?ModalOption $acceptOption = null, ?ModalOption $denyOption = null) {
        $this->contentText = $contentText;
        $this->acceptOption = $acceptOption ?? new ModalOption("Accept");
        $this->denyOption = $denyOption ?? new ModalOption("Deny");
        parent::__construct($title);
    }

    public function getAcceptOption(): ModalOption {
        return $this->acceptOption;
    }

    public function getDenyOption(): ModalOption {
        return $this->denyOption;
    }

    public function setAcceptListener(?Closure $closure): void {
        $this->acceptOption->setSubmitListener($closure);
    }

    public function setAcceptText(string $text): void {
        $this->acceptOption->setText($text);
    }

    public function setDenyListener(?Closure $closure): void {
        $this->denyOption->setSubmitListener($closure);
    }

    public function setDenyText(string $text): void {
        $this->denyOption->setText($text);
    }

    protected function getType(): string {
        return Form::TYPE_MODAL_FORM;
    }

    public function handleResponse(Player $player, $data): void {
        if(!is_bool($data)) {
            throw new FormValidationException("$data is not a valid response");
        }

        if($data) {
            $this->onAccept($player);
            $this->acceptOption->notifySubmit($player);
        } else {
            $this->onDeny($player);
            $this->denyOption->notifySubmit($player);
        }
    }

    protected function serializeBody(): array {
        return [
            "content" => $this->contentText,
            "button1" => $this->acceptOption->getText(),
            "button2" => $this->denyOption->getText()
        ];
    }

    protected function onAccept(Player $player): void {}

    protected function onDeny(Player $player): void {}

}