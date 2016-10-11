<?php

namespace App\Mapper;

use App\Entity\User;

class UserMapper {

    public static function mapSingle(User $user)
    {
        $object = new \stdClass();

        $object->id                   = $user->getId();
        $object->username             = $user->getUsername();
        $object->mail                 = $user->getMail();
        $object->create_notifications = $user->getCreateNotifications();
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