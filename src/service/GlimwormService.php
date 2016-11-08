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

    const FIELD_TIME       = 'time';
    const FIELD_APPID      = 'appid';
    const FIELD_BATTERY    = 'battery';
    const FIELD_CITY       = 'city';
    const FIELD_DEVICETYPE = 'devicetype';
    const FIELD_DOWNSENSOR = 'downsensor';
    const FIELD_ID         = 'id';
    const FIELD_MSGTYPE    = 'msgtype';
     const FIELD_PSTATUS    = 'pstatus';
    const FIELD_RSSI       = 'rssi';
     const FIELD_SCHEMA     = 'schema';
    const FIELD_STATUS     = 'status';
    const FIELD_TOPSENSOR  = 'topsensor';
    const FIELD_TS         = 'ts';
    const FIELD_TSTATUS    = 'tstatus';
    const FIELD_VEHICLE    = 'vehicle';

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

            $columns = array_flip($json['results'][0]['series'][0]['columns']);

            $records = array_reverse($json['results'][0]['series'][0]['values']);

            foreach ($records as $row) {

                $time = new \DateTime(substr(str_replace('T', ' ', $row[$columns[self::FIELD_TIME]]), 0, 26));

                $data = $this->dataRepo->findOneBy(['device'=>$device,'time'=>$time]);
                if (null === $data) {
                    $data = new GlimwormData();
                    $data->setTime($time);
                    $data->setDevice($device);
                    $device->addData($data);
                    $this->em->persist($data);
                }
                $data->setBattery($row[$columns[self::FIELD_BATTERY]]);
                $data->setCity($row[$columns[self::FIELD_CITY]]);
                $data->setDevicetype($row[$columns[self::FIELD_DEVICETYPE]]);
                $data->setDownsensor($row[$columns[self::FIELD_DOWNSENSOR]]);
                $data->setGlimwormId($row[$columns[self::FIELD_ID]]);
                $data->setMsgtype($row[$columns[self::FIELD_MSGTYPE]]);
                $data->setRssi($row[$columns[self::FIELD_RSSI]]);
                $data->setStatus($row[$columns[self::FIELD_STATUS]]);
                $data->setTopsensor($row[$columns[self::FIELD_TOPSENSOR]]);
                $data->setTs($row[$columns[self::FIELD_TS]]);
                $data->setVehicle($row[$columns[self::FIELD_VEHICLE]]);
                $data->setPstatus($row[$columns[self::FIELD_PSTATUS]]);
                $data->setSchema($row[$columns[self::FIELD_SCHEMA]]);
            }
        }
        $this->em->flush();
    }
}