<?php

namespace App\Controller;

use App\Entity\Token;
use App\Exception\NotAuthenticatedException;
use App\Service\AuthService;
use Slim\Http\Request;
use Slim\Http\Response;

class Controller {

    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $ci;

    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * AccountController constructor.
     * @param \Interop\Container\ContainerInterface $ci
     */
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
        $this->authService = $ci->get('auth');
    }

    protected function requireAuthentication(Request $request, Response $response) {
        $get = $request->getQueryParams();
        if (!isset($get['token'])) {
            $response = $response->withStatus(401);
            return $response;
        }

        try {
            $this->authService->requireAuthentication($get['token']);
        } catch (NotAuthenticatedException $e) {
            $response = $response->withStatus(401);
            return $response;
        }
    }

    protected function getUser(Request $request) {
        $get = $request->getQueryParams();
        /**
         * @var Token $token
         */

        $token = $this->authService->requireAuthentication($get['token']);

        return $token->getUser();
    }
}