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
     * @ORM\Column(name="mail", type="string", length=255, precision=0, scale=0, nullable=false, unique=true)
     */
    private $nummer;

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
     * Set nummer
     *
     * @param string $nummer
     *
     * @return Telefoon
     */
    public function setNummer($nummer)
    {
        $this->nummer = $nummer;

        return $this;
    }

    /**
     * Get nummer
     *
     * @return string
     */
    public function getNummer()
    {
        return $this->nummer;
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
