<?php
/**
 * Created by IntelliJ IDEA.
 * User: Elio
 * Date: 06/10/2018
 * Time: 15:49
 */

namespace App\Services;


class MainService
{

    public function getInfo(){
        return array('a'=>1,
                                 'b'=>2,
                                 'c'=>array('d'=>100)
            );
    }



}