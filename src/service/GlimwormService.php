<?php

namespace App\Service;

use App\Entity\GlimwormData;
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
        $this->updateData();

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

    protected function updateData() {
        $devices = $this->deviceRepo->findAll();
        foreach ($devices as $device) {
            /**
             * @var GlimwormDevice $device
             */
            $json = json_decode(file_get_contents(self::DATA_URL . $device->getGlimwormId()), true);

            $records = array_reverse($json['results'][0]['series'][0]['values']);

            foreach ($records as $row) {

                $time = new \DateTime(substr(str_replace('T', ' ', $row[0]), 0, 26));

                $data = $this->dataRepo->findOneBy(['device'=>$device,'time'=>$time]);
                if (null === $data) {
                    $data = new GlimwormData();
                    $data->setTime($time);
                    $data->setDevice($device);
                    $device->addData($data);
                    $this->em->persist($data);
                }
                $data->setBattery($row[2]);
                $data->setCity($row[3]);
                $data->setDevicetype($row[4]);
                $data->setDownsensor($row[5]);
                $data->setGlimwormId($row[6]);
                $data->setMsgtype($row[7]);
                $data->setRssi($row[8]);
                $data->setStatus($row[9]);
                $data->setTopsensor($row[10]);
                $data->setTs($row[11]);
                $data->setVehicle($row[12]);
            }
        }
        $this->em->flush();
    }
}