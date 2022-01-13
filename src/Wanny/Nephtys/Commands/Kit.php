<?php
namespace Wanny\Nephtys\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;
use Wanny\Nephtys\Forms\SimpleForm;
use Wanny\Nephtys\utils\KitManager;

class Kit extends PluginCommand{
    private $core;
    public function __construct(Core $core)
    {
        parent::__construct("kit", $core);
        $this->setDescription("Ouvrir le menu des kits");
        $this->core = $core;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof NephtysPlayer) $this->Kit($sender);
    }

    public function Kit(NephtysPlayer $player)
    {
        $form = new SimpleForm(function (NephtysPlayer $player, $data){
            $result = $data;
            if($result === null) return;
            if ($data == 0) $this->KitGrade($player);
            if ($data == 1) return;
            if ($data == 2) $this->KitAutre($player);
        });
        $form->setTitle("Kit");
        $form->setContent('Choisissez le type de kit');
        $form->addButton("Grades");
        $form->addButton("Ligues");
        $form->addButton("Autres");
        $form->addButton("Acheter un kit");
        $form->addButton("Quitter");
        $player->sendForm($form);
    }

    public function KitGrade(NephtysPlayer $player)
    {
        $form = new SimpleForm(function (NephtysPlayer $player, $data){
            $result = $data;
            if($result === null) return;
            if ($data == 0) KitManager::sendKit($player, "Joueur");
            if ($data == 1) KitManager::sendKit($player, "Scribe");
            if ($data == 2) KitManager::sendKit($player, "Vizir");
            if ($data == 3) KitManager::sendKit($player, "Pharaon");
            if ($data == 4) $player->sendMessage("Bon jeu!");
        });
        $form->setTitle("Kit");
        $form->setContent('Choisissez votre kit');
        $form->addButton("Joueur");
        $form->addButton("Scribe");
        $form->addButton("Vizir");
        $form->addButton("Pharaon");
        $form->addButton("Quitter");
        $player->sendForm($form);
    }

    public function KitAutre(NephtysPlayer $player)
    {
        $form = new SimpleForm(function (NephtysPlayer $player, $data){
            $result = $data;
            if($result === null) return;
            if ($data == 0) KitManager::sendKit($player, "builder");
            if ($data == 1) KitManager::sendKit($player, "potion");
            if ($data == 2) $player->sendMessage("Bon jeu!");
        });
        $form->setTitle("Kit");
        $form->setContent('Choisissez votre kit');
        $form->addButton("Buildeur");
        $form->addButton("Potions");
        $form->addButton("Quitter");
        $player->sendForm($form);
    }

}