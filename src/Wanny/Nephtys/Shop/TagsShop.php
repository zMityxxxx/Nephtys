<?php
namespace Wanny\Nephtys\Shop;

use Wanny\Nephtys\Forms\element\Label;
use Wanny\Nephtys\Forms\variant\CustomForm;

class TagsShop extends CustomForm {
    public function __construct()
    {
        parent::__construct("Acheter un tag");
    }

    protected function onCreation(): void
    {
        $this->addElement("", new Label("En développement"));
    }
}