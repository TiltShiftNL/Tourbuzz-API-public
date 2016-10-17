<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Entity\UserRepo")
 */
class User
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
     * @ORM\Column(name="username", type="string", length=255, precision=0, scale=0, nullable=false, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="create_notifications", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $createNotifications;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Token", mappedBy="user")
     */
    private $tokens;

    /**
     * @var \App\Entity\VergetenToken
     *
     * @ORM\OneToOne(targetEntity="App\Entity\VergetenToken", inversedBy="user")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vergeten_token_id", referencedColumnName="id", unique=true, nullable=true)
     * })
     */
    private $vergetenToken;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tokens = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set createNotifications
     *
     * @param boolean $createNotifications
     *
     * @return User
     */
    public function setCreateNotifications($createNotifications)
    {
        $this->createNotifications = $createNotifications;

        return $this;
    }

    /**
     * Get createNotifications
     *
     * @return boolean
     */
    public function getCreateNotifications()
    {
        return $this->createNotifications;
    }

    /**
     * Add token
     *
     * @param \App\Entity\Token $token
     *
     * @return User
     */
    public function addToken(\App\Entity\Token $token)
    {
        $this->tokens[] = $token;

        return $this;
    }

    /**
     * Remove token
     *
     * @param \App\Entity\Token $token
     */
    public function removeToken(\App\Entity\Token $token)
    {
        $this->tokens->removeElement($token);
    }

    /**
     * Get tokens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Set vergetenToken
     *
     * @param \App\Entity\VergetenToken $vergetenToken
     *
     * @return User
     */
    public function setVergetenToken(\App\Entity\VergetenToken $vergetenToken = null)
    {
        $this->vergetenToken = $vergetenToken;

        return $this;
    }

    /**
     * Get vergetenToken
     *
     * @return \App\Entity\VergetenToken
     */
    public function getVergetenToken()
    {
        return $this->vergetenToken;
    }
}