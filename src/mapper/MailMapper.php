<?php

namespace App\Mapper;

use App\Entity\Mail;

class MailMapper {

    public static function mapSingle(Mail $mail)
    {
        $object = new \stdClass();

        $object->id                 = $mail->getId();
        $object->mail               = $mail->getMail();
        $object->name               = $mail->getName();
        $object->created            = $mail->getCreated();
        $object->confirmed          = $mail->getConfirmed();
        $object->unsubscribeRequest = $mail->getUnsubscribedRequested();
        $object->organisation       = $mail->getOrganisation();
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