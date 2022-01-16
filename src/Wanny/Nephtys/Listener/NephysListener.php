<?php
namespace Wanny\Nephtys\Listener;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;
use Wanny\Nephtys\utils\EloSystem;
use Wanny\Nephtys\utils\Utils;

class NephysListener implements Listener{

    private $core;

    public function __construct(Core $core)
    {
        $this->core = $core;
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if ($player instanceof NephtysPlayer){
            $player->create();
            Utils::savePermissions($player);
        }
    }

    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        if ($player instanceof NephtysPlayer){
            $nrml = $player->getRank("normal");
            $pvp = $player->getRank("pvp");
            $elo = $player->getElo();
            $message = $event->getMessage();
            $name = $player->getName();
            $mc = $player->getFormat($nrml);
            $mc = str_replace(['{pvpgrade}', '{elo}', '{grade_normal}', '{joueur}', '{message}'], [$pvp, $elo, $nrml, $name, $message], $mc);
            $event->setFormat($mc);
        }
    }

    public function onDeath(PlayerDeathEvent $event){
        $victim = $event->getEntity();
        $cause = $victim->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent){
            $damager = $cause->getDamager();
            if ($victim instanceof NephtysPlayer and $damager instanceof NephtysPlayer){
                $rating = new EloSystem($damager->getElo(), $victim->getElo(), EloSystem::WIN, EloSystem::LOST);
                $resultats = $rating->getNewRatings();
                $elowinner = $resultats['a'];
                $elolooser = $resultats['b'] > 0 ? $resultats['b'] : 0;
                $damager->setElos($elowinner);
                $victim->setElos($elolooser);
                $victim->addDeath(1);
                $damager->addKill(1);

                if ($damager->getElo() >= 125){
                    $damager->addRank();
                    $damager->setElos(NephtysPlayer::ELO_BASE);
                }

            }
        }
    }

    public function creation(PlayerCreationEvent $event) : void{
        $event->setPlayerClass(NephtysPlayer::class);
    }

}