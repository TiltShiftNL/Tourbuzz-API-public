<?php

namespace App\Service;

use App\Entity\GlimwormDataRepo;
use App\Entity\GlimwormDevice;
use App\Entity\GlimwormDeviceRepo;
use Doctrine\ORM\EntityManager;

class GlimwormService {

    const DEVICES_URL = 'http://dev.ibeaconlivinglab.com:1888/parkingcams';
    const DATA_URL    = 'http://dev.ibeaconlivinglab.com:1888/getparkingdata/';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var GlimwormDeviceRepo
     */
    protected $deviceRepo;

    /**
     * @var GlimwormDataRepo
     */
    protected $dataRepo;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->deviceRepo = $this->em->getRepository('App\Entity\GlimwormDevice');
        $this->dataRepo   = $this->em->getRepository('App\Entity\GlimwormData');
    }

    public function update() {
        echo "Updating\n";

        $this->updateDevices();

        echo "\n";
    }

    protected function updateDevices() {
        $devices = json_decode(file_get_contents(self::DEVICES_URL));
        foreach ($devices as $device) {
            $obj = $this->deviceRepo->findOneBy(['glimwormId' => $device->id]);
            if (null === $obj) {
                $obj = new GlimwormDevice();
                $obj->setGlimwormId($device->id);
                $this->em->persist($obj);
            }
            $obj->setDeviceTypeId($device->deviceTypeID);
            $obj->setLat($device->lat);
            $obj->setLon($device->lon);
            $obj->setUUID($device->UUID);
            $obj->setStatus($device->status);
            $obj->setTimestamp($device->timestamp);
            $obj->setBattery($device->battery);
            $obj->setFront($device->front);
            $obj->setBottom($device->bottom);
            $obj->setLoraAppid($device->lora_appid);
            $obj->setLoraKey($device->lora_key);
            $obj->setLoraDevid($device->lora_devid);
            $obj->setDisplayname($device->displayname);
        }
        $this->em->flush();
    }
}