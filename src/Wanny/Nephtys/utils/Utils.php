<?php
namespace Wanny\Nephtys\utils;

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
}