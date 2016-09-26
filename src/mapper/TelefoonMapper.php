<?php

namespace App\Mapper;

use App\Entity\Telefoon;

class TelefoonMapper {

    public static function mapSingle(Telefoon $telefoon)
    {
        $object = new \stdClass();

        $object->id      = $telefoon->getId();
        $object->mail    = $telefoon->getNumber();
        $object->created = $telefoon->getCreated();
        $object->created = $telefoon->getLanguage();
        return $object;
    }

    public static function mapCollection($collection) {
        $arr = [];

        foreach ($collection as $obj) {
            $arr[$obj->getId()] = self::mapSingle($obj);
        }

        return $arr;
    }
}