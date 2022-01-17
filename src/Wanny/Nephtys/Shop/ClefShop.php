<?php
namespace Wanny\Nephtys\Shop;

use Wanny\Nephtys\Forms\element\Label;
use Wanny\Nephtys\Forms\variant\CustomForm;

class ClefShop extends CustomForm {
    public function __construct()
    {
        parent::__construct("Acheter une clef");
    }

    protected function onCreation(): void
    {
        $this->addElement("", new Label("En développement"));
    }

}