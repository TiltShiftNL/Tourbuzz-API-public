<?php

namespace App\Mapper;

use App\Entity\Bericht;

class BerichtMapper {

    public static function mapSingle(Bericht $bericht)
    {
        var_dump(json_encode($bericht->));die;
    }

    public static function mapCollection($collection) {
        $arr = [];

        foreach ($collection as $obj) {
            $arr[] = self::mapSingle($obj);
        }

        return $arr;
    }
}