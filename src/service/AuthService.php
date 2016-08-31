<?php

namespace App\Service;

use App\Entity\Token;
use App\Exception\UnknownCredentialsException;
use Slim\Http\Request;
use Slim\Http\Response;

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
     * AuthService constructor.
     * @param \Interop\Container\ContainerInterface $ci
     */
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    /**
     * @return string
     */
    protected function createPrefix() {
        $alphabet = './' . implode("", array_merge(range("0", "9"), range ("A", "Z"), range("a", "z")));
        $salt = "";
        while (strlen($salt) < 23) $salt .= $alphabet[mt_rand(0, strlen($alphabet))];
        return '$2a$12$' . $salt;
    }

    /**
     * @return string
     */
    protected function createToken() {
        $alphabet = implode("", array_merge(range("0", "9"), range("a", "f")));
        $token = "";
        while (strlen($token) < 40) $token .= $alphabet[mt_rand(0, strlen($alphabet))];
        return $token;
    }

    /**
     * @param string $username
     * @param string $password
     * @return Token
     * @throws UnknownCredentialsException
     */
    public function login($username, $password) {

    }

    public function create($username, $password) {
        
    }
}