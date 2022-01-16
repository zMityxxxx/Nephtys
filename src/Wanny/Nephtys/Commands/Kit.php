<?php
namespace Wanny\Nephtys\Commands;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\Forms\element\Button;
use Wanny\Nephtys\Forms\variant\SimpleForm;
use Wanny\Nephtys\NephtysPlayer;
use Wanny\Nephtys\utils\KitManager;

class Kit extends Command {
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("kit");
        $this->setDescription("Ouvrir le menu des kits");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer) $this->Kit($sender);
    }

    public function Kit(NephtysPlayer $player)
    {
        $form = new SimpleForm("Kit", "Choisissez votre kit");
        $form->addButton(new Button("Grade", null, function (NephtysPlayer $player){
            $this->KitGrade($player);
        }));
        $form->addButton(new Button("Autres", null, function (NephtysPlayer $player){
            $this->KitAutre($player);
        }));
        $buttons = [new Button("Acheter un kit"), new Button("League")];
        foreach ($buttons as $button) $form->addButton($button);
        $player->sendForm($form);
    }

    public function KitGrade(NephtysPlayer $player)
    {

        $form = new SimpleForm("Kit", "Choisissez votre kit");
        $form->addButton(new Button("Joueur", null, function (NephtysPlayer $player){
            KitManager::sendKit($player, "Joueur");
        }));
        $form->addButton(new Button("Scribe", null, function (NephtysPlayer $player){
            KitManager::sendKit($player, "Scribe");
        }));
        $form->addButton(new Button("Vizir", null, function (NephtysPlayer $player){
            KitManager::sendKit($player, "Vizir");
        }));
        $form->addButton(new Button("Pharaon", null, function (NephtysPlayer $player){
            KitManager::sendKit($player, "Pharaon");
        }));
        $player->sendForm($form);
    }

    public function KitAutre(NephtysPlayer $player)
    {
        $form = new SimpleForm("Kit", "Choisissez votre kit");
        $form->addButton(new Button("Buildeur", null, function (NephtysPlayer $player){
            KitManager::sendKit($player, "builder");
        }));
        $form->addButton(new Button("Potions", null, function (NephtysPlayer $player){
            KitManager::sendKit($player, "potion");
        }));
        $player->sendForm($form);
    }

}