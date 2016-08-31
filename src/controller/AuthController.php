<?php

namespace App\Controller;

use App\Service\AuthService;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController {
    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $ci;

    /**
     * @var AuthService
     */
    protected $authService;
    //Constructor
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci          = $ci;
        $this->authService = $ci->get('auth');
    }

    public function login(Request $request, Response $response, $args) {
        $this->authService->login('test','test');
    }

    public function create(Request $request, Response $response, $args) {
        $this->authService->create('test','test');
    }
}