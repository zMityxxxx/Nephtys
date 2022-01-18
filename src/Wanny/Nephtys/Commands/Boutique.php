<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\Forms\element\Button;
use Wanny\Nephtys\Forms\variant\SimpleForm;
use Wanny\Nephtys\NephtysPlayer;
use Wanny\Nephtys\Shop\ClefShop;
use Wanny\Nephtys\Shop\RankShop;
use Wanny\Nephtys\Shop\SlotShop;
use Wanny\Nephtys\Shop\TagsShop;

class Boutique extends Command {

    private $core;

    public function __construct(Core $core)
    {
        parent::__construct("boutique");
        $this->setDescription("Ouvrir la boutique farm2win");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer) {
            $form = new SimpleForm("§8Boutique", "§9§l»§r§7 Bienvenue dans la boutique, choisissez la catégorie qui vous plaît");
            $form->addButton(new Button("Acheter un slot \n§9Enderchest", null, function (NephtysPlayer $player){$player->sendForm(new SlotShop());}));
            $form->addButton(new Button("Acheter une \n§9Clef de box", null, function (NephtysPlayer $player){$player->sendForm(new ClefShop());}));
            $form->addButton(new Button("Acheter un\n§9Tag", null, function (NephtysPlayer $player){$player->sendForm(new TagsShop());}));
            $form->addButton(new Button("Acheter un\n§9Grade", null, function (NephtysPlayer $player){$player->sendForm(new RankShop());}));
            $form->addButton(new Button("Acheter un\n§9Kit", null, function (NephtysPlayer $player){$player->sendMessage("En développement");}));
            $form->addButton(new Button("Acheter une\n§9Commande", null, function (NephtysPlayer $player){$player->sendMessage("En développement");}));
            $sender->sendForm($form);
        }
    }

}
