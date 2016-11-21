<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VialisDynamic
 *
 * @ORM\Table(name="vialis_dynamic")
 * @ORM\Entity(repositoryClass="App\Entity\VialisDynamicRepo")
 */
class VialisDynamic
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="vialis_dynamic_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="vialis_id", type="string", length=255, precision=0, scale=0, nullable=false, unique=true)
     */
    private $vialisId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_full", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $isFull;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_updated", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lastUpdated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="open", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $open;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacity", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $capacity;

    /**
     * @var integer
     *
     * @ORM\Column(name="vacant", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $vacant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_pull", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $lastPull;


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
     * Set description
     *
     * @param string $description
     *
     * @return VialisDynamic
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set vialisId
     *
     * @param string $vialisId
     *
     * @return VialisDynamic
     */
    public function setVialisId($vialisId)
    {
        $this->vialisId = $vialisId;

        return $this;
    }

    /**
     * Get vialisId
     *
     * @return string
     */
    public function getVialisId()
    {
        return $this->vialisId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return VialisDynamic
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isFull
     *
     * @param boolean $isFull
     *
     * @return VialisDynamic
     */
    public function setIsFull($isFull)
    {
        $this->isFull = $isFull;

        return $this;
    }

    /**
     * Get isFull
     *
     * @return boolean
     */
    public function getIsFull()
    {
        return $this->isFull;
    }

    /**
     * Set lastUpdated
     *
     * @param \DateTime $lastUpdated
     *
     * @return VialisDynamic
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * Get lastUpdated
     *
     * @return \DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Set open
     *
     * @param boolean $open
     *
     * @return VialisDynamic
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return boolean
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     *
     * @return VialisDynamic
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set vacant
     *
     * @param integer $vacant
     *
     * @return VialisDynamic
     */
    public function setVacant($vacant)
    {
        $this->vacant = $vacant;

        return $this;
    }

    /**
     * Get vacant
     *
     * @return integer
     */
    public function getVacant()
    {
        return $this->vacant;
    }

    /**
     * Set lastPull
     *
     * @param \DateTime $lastPull
     *
     * @return VialisDynamic
     */
    public function setLastPull($lastPull)
    {
        $this->lastPull = $lastPull;

        return $this;
    }

    /**
     * Get lastPull
     *
     * @return \DateTime
     */
    public function getLastPull()
    {
        return $this->lastPull;
    }
}
