<?php

namespace App\Service;

use App\Entity\Token;
use App\Entity\TokenRepo;
use App\Entity\User;
use App\Entity\UserRepo;
use App\Exception\UnknownCredentialsException;
use App\Exception\UsernameExistsException;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

class AuthService {

    /**
     * @var int
     */
    protected $maxAge = 3600 * 8;

    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $ci;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UserRepo
     */
    protected $userRepo;

    /**
     * @var TokenRepo
     */
    protected $tokenRepo;

    /**
     * AuthService constructor.
     * @param \Interop\Container\ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci) {
        $this->ci        = $ci;
        $this->em        = $this->ci->get('em');
        $this->userRepo  = $this->em->getRepository('App\Entity\User');
        $this->tokenRepo = $this->em->getRepository('App\Entity\Token');
    }

    /**
     * @return string
     */
    protected function createPrefix() {
        $alphabet = './' . implode("", array_merge(range("0", "9"), range ("A", "Z"), range("a", "z")));
        $salt = "";
        while (strlen($salt) < 23) $salt .= $alphabet[mt_rand(0, strlen($alphabet)-1)];
        return '$2a$12$' . $salt;
    }

    /**
     * @return string
     */
    protected function createToken() {
        $alphabet = implode("", array_merge(range("0", "9"), range("a", "f")));
        $token = "";
        while (strlen($token) < 40) $token .= $alphabet[mt_rand(0, strlen($alphabet)-1)];
        return $token;
    }

    /**
     * @param string $username
     * @param string $password
     * @return Token
     * @throws UnknownCredentialsException
     */
    public function login($username, $password) {
        /**
         * @var User $user
         */
        $user = $this->userRepo->findOneByUsername($username);
        if (null === $user) {
            throw new UnknownCredentialsException();
        }

        if (!password_verify($password.$user->getSalt(), $user->getPassword())) {
            throw new UnknownCredentialsException();
        }

        $token = $user->getToken();
        if (null === $token) {
            $token = new Token();
            $token->setUser($user);
            $user->setToken($token);
            $this->em->persist($token);
        }

        $uuid = Uuid::uuid4();
        $token->setToken($uuid->toString());

        /**
         * This method also flushes
         */
        $this->updateToken($token);

        return $token;
    }

    /**
     * @param string $username
     * @param string $password
     * @return User
     * @throws UsernameExistsException
     *
     */
    public function create($username, $password) {
        $user = $this->userRepo->findOneByUsername($username);
        if (null !== $user) {
            throw new UsernameExistsException();
        }

        $user = new User();
        $user->setUsername($username);
        $this->setPassword($user, $password);

        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * @param string $username
     * @param string $password
     * @return User
     * @throws UnknownCredentialsException
     *
     */
    public function update($username, $password) {
        $user = $this->userRepo->findOneByUsername($username);
        if (null === $user) {
            throw new UnknownCredentialsException();
        }
        
        $this->setPassword($user, $password);

        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * @param User $user
     * @param string $password
     * @return User
     */
    protected function setPassword(User $user, $password) {
        $salt = $this->createPrefix();
        $user->setSalt($salt);

        $user->setPassword($this->getHash($password, $salt));

        return $user;
    }

    /**
     * @param string $password
     * @param string $salt
     * @return bool|string
     */
    protected function getHash($password, $salt) {
        $options = array('cost' => 11);
        return password_hash($password.$salt, PASSWORD_BCRYPT, $options);
    }

    /**
     * @param Token $token
     * @param bool $flush
     */
    public function updateToken(Token $token, $flush=true) {
        $now = new \DateTime();
        $token->setLastAction($now);
        if ($flush) {
            $this->em->flush();
        }
    }
}