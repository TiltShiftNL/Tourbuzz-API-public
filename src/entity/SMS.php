<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SMS
 *
 * @ORM\Table(name="sms")
 * @ORM\Entity(repositoryClass="App\Entity\SMSRepo")
 */
class SMS
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
     * @ORM\Column(name="number", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=3, precision=0, scale=0, nullable=false, unique=false)
     */
    private $language;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $text;


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
     * @return SMS
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
     * Set language
     *
     * @param string $language
     *
     * @return SMS
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return SMS
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

    /**
     * Set text
     *
     * @param string $text
     *
     * @return SMS
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}

