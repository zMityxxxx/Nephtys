<?php
namespace Wanny\Nephtys\utils;

use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\Server;
use pocketmine\utils\Config;
use Wanny\Nephtys\Core;
use Wanny\Nephtys\NephtysPlayer;

class Utils {
    public static function traductionTime(int $duration){
        $remainingTime=$duration - time();
        $day=floor($remainingTime / 86400);
        $hourSeconds=$remainingTime % 86400;
        $hour=floor($hourSeconds / 3600);
        $minuteSec=$hourSeconds % 3600;
        $minute=floor($minuteSec / 60);
        $remainingSec=$minuteSec % 60;
        $second=ceil($remainingSec);
        return array(
          'day' => $day,
          'hour' => $hour,
          'minute' => $minute,
          'seconde' => $second
        );
    }

    public static function savePlayerPermissions(?NephtysPlayer $player){
        $c = new Config(Core::getInstance()->getDataFolder() . "format.yml", 2);
        $permissions = $c->get("permissions")[$player->getRank("normal")];
        foreach ($permissions as $permission) {
            $attachment = $player->addAttachment(Core::getInstance());
            $attachment->setPermission($permission, true);
            $player->addAttachment(Core::getInstance(), $permission);
        }
    }

    public static function savePermissions(){
        $spermissions = ["joueur", "vizir", "scribe", "pharaon", "guide", "mod", "admin", "fondateur"];
        foreach ($spermissions as $spermission){
            PermissionManager::getInstance()->addPermission(new Permission($spermission));
        }
    }

    public static function saveEc(NephtysPlayer $player){

    }

}