<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension{

    public function getFunctions(){
        return [
            new TwigFunction('dates',[$this,'getMonth']),
            new TwigFunction('index',[$this,'getIndex']),
        ];
    }

    public function getMonth($start,$month,$year){
        $list=array("Mon"=>[],"Tue"=>[],"Wed"=>[],"Thu"=>[],"Fri"=>[],"Sat"=>[],"Sun"=>[]);
        $keys=array_keys($list);
        $end=date("d",mktime(0,0,0,$month+1,0,$year));
        for($i=$start;$i<$end;$i++){
            $day=date('N',mktime(0,0,$month,$i,$year));
            array_push($list[$keys[$day-1]],$i);
        }
        return $list;
    }

    public function getIndex($key,$tab){
        return array_search($key,array_keys($tab));
    }
}
?>
