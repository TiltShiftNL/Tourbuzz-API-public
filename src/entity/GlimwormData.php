<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GlimwormData
 *
 * @ORM\Table(name="glimworm_data")
 * @ORM\Entity(repositoryClass="App\Entity\GlimwormDataRepo")
 */
class GlimwormData
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="glimworm_data_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $time;

    /**
     * @var integer
     *
     * @ORM\Column(name="battery", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $battery;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="devicetype", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $devicetype;

    /**
     * @var integer
     *
     * @ORM\Column(name="downsensor", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $downsensor;

    /**
     * @var string
     *
     * @ORM\Column(name="glimworm_id", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $glimwormId;

    /**
     * @var string
     *
     * @ORM\Column(name="msgtype", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $msgtype;

    /**
     * @var integer
     *
     * @ORM\Column(name="rssi", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $rssi;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="topsensor", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $topsensor;

    /**
     * @var float
     *
     * @ORM\Column(name="ts", type="float", precision=0, scale=0, nullable=true, unique=false)
     */
    private $ts;

    /**
     * @var integer
     *
     * @ORM\Column(name="vehicle", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $vehicle;

    /**
     * @var string
     *
     * @ORM\Column(name="schema", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $schema;

    /**
     * @var integer
     *
     * @ORM\Column(name="pstatus", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $pstatus;

    /**
     * @var \App\Entity\GlimwormDevice
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\GlimwormDevice", inversedBy="data")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="device_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $device;


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
     * Set time
     *
     * @param \DateTime $time
     *
     * @return GlimwormData
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set battery
     *
     * @param integer $battery
     *
     * @return GlimwormData
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
     * Set city
     *
     * @param string $city
     *
     * @return GlimwormData
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set devicetype
     *
     * @param string $devicetype
     *
     * @return GlimwormData
     */
    public function setDevicetype($devicetype)
    {
        $this->devicetype = $devicetype;

        return $this;
    }

    /**
     * Get devicetype
     *
     * @return string
     */
    public function getDevicetype()
    {
        return $this->devicetype;
    }

    /**
     * Set downsensor
     *
     * @param integer $downsensor
     *
     * @return GlimwormData
     */
    public function setDownsensor($downsensor)
    {
        $this->downsensor = $downsensor;

        return $this;
    }

    /**
     * Get downsensor
     *
     * @return integer
     */
    public function getDownsensor()
    {
        return $this->downsensor;
    }

    /**
     * Set glimwormId
     *
     * @param string $glimwormId
     *
     * @return GlimwormData
     */
    public function setGlimwormId($glimwormId)
    {
        $this->glimwormId = $glimwormId;

        return $this;
    }

    /**
     * Get glimwormId
     *
     * @return string
     */
    public function getGlimwormId()
    {
        return $this->glimwormId;
    }

    /**
     * Set msgtype
     *
     * @param string $msgtype
     *
     * @return GlimwormData
     */
    public function setMsgtype($msgtype)
    {
        $this->msgtype = $msgtype;

        return $this;
    }

    /**
     * Get msgtype
     *
     * @return string
     */
    public function getMsgtype()
    {
        return $this->msgtype;
    }

    /**
     * Set rssi
     *
     * @param integer $rssi
     *
     * @return GlimwormData
     */
    public function setRssi($rssi)
    {
        $this->rssi = $rssi;

        return $this;
    }

    /**
     * Get rssi
     *
     * @return integer
     */
    public function getRssi()
    {
        return $this->rssi;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return GlimwormData
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
     * Set topsensor
     *
     * @param integer $topsensor
     *
     * @return GlimwormData
     */
    public function setTopsensor($topsensor)
    {
        $this->topsensor = $topsensor;

        return $this;
    }

    /**
     * Get topsensor
     *
     * @return integer
     */
    public function getTopsensor()
    {
        return $this->topsensor;
    }

    /**
     * Set ts
     *
     * @param float $ts
     *
     * @return GlimwormData
     */
    public function setTs($ts)
    {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return float
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * Set vehicle
     *
     * @param integer $vehicle
     *
     * @return GlimwormData
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return integer
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set schema
     *
     * @param string $schema
     *
     * @return GlimwormData
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Get schema
     *
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Set pstatus
     *
     * @param integer $pstatus
     *
     * @return GlimwormData
     */
    public function setPstatus($pstatus)
    {
        $this->pstatus = $pstatus;

        return $this;
    }

    /**
     * Get pstatus
     *
     * @return integer
     */
    public function getPstatus()
    {
        return $this->pstatus;
    }

    /**
     * Set device
     *
     * @param \App\Entity\GlimwormDevice $device
     *
     * @return GlimwormData
     */
    public function setDevice(\App\Entity\GlimwormDevice $device = null)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return \App\Entity\GlimwormDevice
     */
    public function getDevice()
    {
        return $this->device;
    }
}
