<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Telefoon
 *
 * @ORM\Table(name="telefoons")
 * @ORM\Entity(repositoryClass="App\Entity\TelefoonRepo")
 */
class Telefoon
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
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, precision=0, scale=0, nullable=false, unique=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=3, precision=0, scale=0, nullable=false, unique=false)
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $created;


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
     * Set number
     *
     * @param string $number
     *
     * @return Telefoon
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Telefoon
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Telefoon
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}