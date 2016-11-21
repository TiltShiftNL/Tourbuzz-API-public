<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParkeerplaatsDynamicXref
 *
 * @ORM\Table(name="parkeerplaats_dynamic_xref")
 * @ORM\Entity(repositoryClass="App\Entity\MailRepo")
 */
class ParkeerplaatsDynamicXref
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="parkeerplaats_dynamic_xref_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="parkeerplaats", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $parkeerplaats;

    /**
     * @var \App\Entity\VialisDynamic
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\VialisDynamic", inversedBy="parkeerplaatsen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vialis_dynamic_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $vialisDynamic;


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
     * Set parkeerplaats
     *
     * @param string $parkeerplaats
     *
     * @return ParkeerplaatsDynamicXref
     */
    public function setParkeerplaats($parkeerplaats)
    {
        $this->parkeerplaats = $parkeerplaats;

        return $this;
    }

    /**
     * Get parkeerplaats
     *
     * @return string
     */
    public function getParkeerplaats()
    {
        return $this->parkeerplaats;
    }

    /**
     * Set vialisDynamic
     *
     * @param \App\Entity\VialisDynamic $vialisDynamic
     *
     * @return ParkeerplaatsDynamicXref
     */
    public function setVialisDynamic(\App\Entity\VialisDynamic $vialisDynamic = null)
    {
        $this->vialisDynamic = $vialisDynamic;

        return $this;
    }

    /**
     * Get vialisDynamic
     *
     * @return \App\Entity\VialisDynamic
     */
    public function getVialisDynamic()
    {
        return $this->vialisDynamic;
    }
}