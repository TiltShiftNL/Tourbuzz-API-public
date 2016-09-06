<?php

namespace App\Controller;

use App\Entity\Bericht;
use App\Entity\BerichtRepo;
use App\Exception\NotAuthenticatedException;
use App\Exception\UsernameExistsException;
use App\Mapper\BerichtMapper;
use App\Mapper\UserMapper;
use App\Service\AuthService;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

class AccountController {

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

    public function create(Request $request, Response $response, $args) {
        $get = $request->getQueryParams();
        if (!isset($get['token'])) {
            $response = $response->withStatus(401);
            return $response;
        }

        $authService = $this->ci->get('auth');

        try {
            $authService->requireAuthentication($get['token']);
        } catch (NotAuthenticatedException $e) {
            $response = $response->withStatus(401);
            return $response;
        }

        $post = $request->getParsedBody();
        if (!isset($post['username']) || !isset($post['password'])  || !isset($post['mail'])) {
            $response = $response = $response->withStatus(406);
            return $response;
        }

        try {
            $this->authService->create($post['username'], $post['password'], $post['mail']);
        } catch (UsernameExistsException $e) {
            $response = $response->withJson(['error' => 'username exists'])->withStatus(409);
            return $response;
        }

        $response = $response->withJson(['success' => true]);
        return $response;
    }

    public function index(Request $request, Response $response, $args) {
        $get = $request->getQueryParams();
        if (!isset($get['token'])) {
            $response = $response->withStatus(401);
            return $response;
        }

        $authService = $this->ci->get('auth');

        try {
            $authService->requireAuthentication($get['token']);
        } catch (NotAuthenticatedException $e) {
            $response = $response->withStatus(401);
            return $response;
        }

        $users = $this->authService->getAllUsers();

        $mappedUsers = UserMapper::mapCollection($users);

        $response = $response->withJson($mappedUsers);
        return $response;
    }
}