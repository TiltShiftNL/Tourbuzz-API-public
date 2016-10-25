<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GlimwormDevice
 *
 * @ORM\Table(name="glimworm_device")
 * @ORM\Entity(repositoryClass="App\Entity\GlimwormDeviceRepo")
 */
class GlimwormDevice
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="users_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="device_type_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $deviceTypeId;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lon", type="float", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lon;

    /**
     * @var string
     *
     * @ORM\Column(name="UUID", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $UUID;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="timestamp", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="battery", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $battery;

    /**
     * @var integer
     *
     * @ORM\Column(name="front", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $front;

    /**
     * @var integer
     *
     * @ORM\Column(name="bottom", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $bottom;

    /**
     * @var string
     *
     * @ORM\Column(name="lora_appid", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lora_appid;

    /**
     * @var string
     *
     * @ORM\Column(name="lora_key", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lora_key;

    /**
     * @var integer
     *
     * @ORM\Column(name="lora_devid", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lora_devid;

    /**
     * @var integer
     *
     * @ORM\Column(name="displayname", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $displayname;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\GlimwormData", mappedBy="device")
     */
    private $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set deviceTypeId
     *
     * @param integer $deviceTypeId
     *
     * @return GlimwormDevice
     */
    public function setDeviceTypeId($deviceTypeId)
    {
        $this->deviceTypeId = $deviceTypeId;

        return $this;
    }

    /**
     * Get deviceTypeId
     *
     * @return integer
     */
    public function getDeviceTypeId()
    {
        return $this->deviceTypeId;
    }

    /**
     * Set lat
     *
     * @param float $lat
     *
     * @return GlimwormDevice
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param float $lon
     *
     * @return GlimwormDevice
     */
    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * Get lon
     *
     * @return float
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Set uUID
     *
     * @param string $uUID
     *
     * @return GlimwormDevice
     */
    public function setUUID($uUID)
    {
        $this->UUID = $uUID;

        return $this;
    }

    /**
     * Get uUID
     *
     * @return string
     */
    public function getUUID()
    {
        return $this->UUID;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return GlimwormDevice
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set timestamp
     *
     * @param integer $timestamp
     *
     * @return GlimwormDevice
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set battery
     *
     * @param integer $battery
     *
     * @return GlimwormDevice
     */
    public function setBattery($battery)
    {
        $this->battery = $battery;

        return $this;
    }

    /**
     * Get battery
     *
     * @return integer
     */
    public function getBattery()
    {
        return $this->battery;
    }

    /**
     * Set front
     *
     * @param integer $front
     *
     * @return GlimwormDevice
     */
    public function setFront($front)
    {
        $this->front = $front;

        return $this;
    }

    /**
     * Get front
     *
     * @return integer
     */
    public function getFront()
    {
        return $this->front;
    }

    /**
     * Set bottom
     *
     * @param integer $bottom
     *
     * @return GlimwormDevice
     */
    public function setBottom($bottom)
    {
        $this->bottom = $bottom;

        return $this;
    }

    /**
     * Get bottom
     *
     * @return integer
     */
    public function getBottom()
    {
        return $this->bottom;
    }

    /**
     * Set loraAppid
     *
     * @param string $loraAppid
     *
     * @return GlimwormDevice
     */
    public function setLoraAppid($loraAppid)
    {
        $this->lora_appid = $loraAppid;

        return $this;
    }

    /**
     * Get loraAppid
     *
     * @return string
     */
    public function getLoraAppid()
    {
        return $this->lora_appid;
    }

    /**
     * Set loraKey
     *
     * @param string $loraKey
     *
     * @return GlimwormDevice
     */
    public function setLoraKey($loraKey)
    {
        $this->lora_key = $loraKey;

        return $this;
    }

    /**
     * Get loraKey
     *
     * @return string
     */
    public function getLoraKey()
    {
        return $this->lora_key;
    }

    /**
     * Set loraDevid
     *
     * @param integer $loraDevid
     *
     * @return GlimwormDevice
     */
    public function setLoraDevid($loraDevid)
    {
        $this->lora_devid = $loraDevid;

        return $this;
    }

    /**
     * Get loraDevid
     *
     * @return integer
     */
    public function getLoraDevid()
    {
        return $this->lora_devid;
    }

    /**
     * Set displayname
     *
     * @param integer $displayname
     *
     * @return GlimwormDevice
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * Get displayname
     *
     * @return integer
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * Add datum
     *
     * @param \App\Entity\GlimwormData $datum
     *
     * @return GlimwormDevice
     */
    public function addDatum(\App\Entity\GlimwormData $datum)
    {
        $this->data[] = $datum;

        return $this;
    }

    /**
     * Remove datum
     *
     * @param \App\Entity\GlimwormData $datum
     */
    public function removeDatum(\App\Entity\GlimwormData $datum)
    {
        $this->data->removeElement($datum);
    }

    /**
     * Get data
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getData()
    {
        return $this->data;
    }
}
