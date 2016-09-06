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
     * @var \App\Entity\Token
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Token", inversedBy="user")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="token_id", referencedColumnName="id", unique=true, nullable=true)
     * })
     */
    private $token;

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
     * Set token
     *
     * @param \App\Entity\Token $token
     *
     * @return User
     */
    public function setToken(\App\Entity\Token $token = null)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return \App\Entity\Token
     */
    public function getToken()
    {
        return $this->token;
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