<?php

namespace App\Mapper;

use App\Entity\Bericht;

class BerichtMapper {

    public static function mapSingle(Bericht $bericht, $imageUrl)
    {
        $object = new \stdClass();

        $object->id           = $bericht->getId();
        $object->old_id       = $bericht->getOldId();
        $object->title        = $bericht->getTitle();
        $object->body         = $bericht->getBody();
        $object->advice       = $bericht->getAdvice();
        $object->title_en     = $bericht->getTitleEn();
        $object->body_en      = $bericht->getBodyEn();
        $object->advice_en    = $bericht->getAdviceEn();
        $object->title_es     = $bericht->getTitleEs();
        $object->body_es      = $bericht->getBodyEs();
        $object->advice_es    = $bericht->getAdviceEs();
        $object->title_fr     = $bericht->getTitleFr();
        $object->body_fr      = $bericht->getBodyFr();
        $object->advice_fr    = $bericht->getAdviceFr();
        $object->title_de     = $bericht->getTitleDe();
        $object->body_de      = $bericht->getBodyDe();
        $object->advice_de    = $bericht->getAdviceDe();
        $object->startdate    = $bericht->getStartDate()->format('Y-m-d');
        $object->enddate      = $bericht->getEndDate()->format('Y-m-d');
        $object->category     = $bericht->getCategory();
        $object->link         = $bericht->getLink();
        if (null !== $bericht->getImageId()) {
            $object->image_url = $imageUrl . $bericht->getImageId();
            $object->image_id  = $bericht->getImageId();
        }
        $object->important    = $bericht->getImportant();
        $object->is_live      = $bericht->getIsLive();
        $object->include_map  = $bericht->getIncludeMap();
        $object->location_lat = $bericht->getLocationLat();
        $object->location_lng = $bericht->getLocationLng();
        $object->status       = $bericht->getStatus();
        $loc = [];
        if (null != $bericht->getLocationLat() && null != $bericht->getLocationLng()) {
            $loc = ['lat' => $bericht->getLocationLat(), 'lng' => $bericht->getLocationLng()];
        }
        $object->location = $loc;
        return $object;
    }

    public static function mapCollection($collection, $imageUrl) {
        $arr = [];

        foreach ($collection as $obj) {
            $arr[$obj->getId()] = self::mapSingle($obj, $imageUrl);
        }

        return $arr;
    }
}