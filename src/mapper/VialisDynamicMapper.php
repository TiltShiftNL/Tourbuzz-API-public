<?php

namespace App\Mapper;

use App\Entity\VialisDynamic;

class VialisDynamicMapper {

    public static function mapSingle(VialisDynamic $dynamic)
    {
        $object = new \stdClass();

        $object->id           = $dynamic->getId();
        $object->description  = $dynamic->getDescription();
        $object->vialis_id    = $dynamic->getVialisId();
        $object->name         = $dynamic->getName();
        $object->full         = $dynamic->getIsFull();
        $object->last_updated = $dynamic->getLastUpdated()->format('d-m-Y H:i:s');
        $object->open         = $dynamic->getOpen();
        $object->capacity     = $dynamic->getCapacity();
        $object->vacant       = $dynamic->getVacant();
        $object->last_pull    = $dynamic->getLastPull()->format('d-m-Y H:i:s');

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