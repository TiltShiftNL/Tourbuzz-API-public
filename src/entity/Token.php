<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Token
 *
 * @ORM\Table(name="tokens")
 * @ORM\Entity(repositoryClass="App\Entity\TokenRepo")
 */
class Token
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tokens_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, precision=0, scale=0, nullable=true, unique=true)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastAction", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $lastAction;

    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tokens")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;


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
     * Set token
     *
     * @param string $token
     *
     * @return Token
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set lastAction
     *
     * @param \DateTime $lastAction
     *
     * @return Token
     */
    public function setLastAction($lastAction)
    {
        $this->lastAction = $lastAction;

        return $this;
    }

    /**
     * Get lastAction
     *
     * @return \DateTime
     */
    public function getLastAction()
    {
        return $this->lastAction;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return Token
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}