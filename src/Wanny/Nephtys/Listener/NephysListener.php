<?php
namespace Wanny\Nephtys\Listener;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class NephysListener implements Listener{
    private $core;
    public function __construct(Core $core)
    {
        $this->core = $core;
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if ($player instanceof NephtysPlayer){
            if (!$player->hasPlayedBefore()){
                $player->create();
            }
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
        /*$cause = $victim->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent){
            $damager = $cause->getDamager();
            if ($damager instanceof NephtysPlayer and $victim instanceof NephtysPlayer){

            }
        }
        */
    }

    public function creation(PlayerCreationEvent $event) : void{
        $event->setPlayerClass(NephtysPlayer::class);
    }

}
