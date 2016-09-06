<?php

namespace App\Controller;

use App\Exception\UnknownCredentialsException;
use App\Exception\UsernameExistsException;
use App\Mapper\UserMapper;
use Slim\Http\Request;
use Slim\Http\Response;

class AccountController extends Controller {

    public function create(Request $request, Response $response, $args) {
        $this->requireAuthentication($request, $response);

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
        $this->requireAuthentication($request, $response);

        $users = $this->authService->getAllUsers();

        $mappedUsers = UserMapper::mapCollection($users);

        $response = $response->withJson($mappedUsers);
        return $response;
    }

    public function single(Request $request, Response $response, $args) {
        $this->requireAuthentication($request, $response);

        $user = $this->authService->getByUsername($args['username']);

        if (null === $user) {
            $response = $response->withStatus(404);
            return $response;
        }

        $mappedUser = UserMapper::mapSingle($user);

        $response = $response->withJson($mappedUser);
        return $response;
    }

    public function update(Request $request, Response $response, $args) {
        $this->requireAuthentication($request, $response);

        $post = $request->getParsedBody();
        if (!isset($post['username']) || !isset($post['mail'])) {
            $response = $response = $response->withStatus(406);
            return $response;
        }

        $password = isset($post['password']) ? $post['password'] : null;

        try {
            $this->authService->update($post['username'], $password, $post['mail']);
        } catch (UnknownCredentialsException $e) {
            $response = $response->withJson(['error' => 'Unknown user'])->withStatus(409);
            return $response;
        }

        $response = $response->withJson(['success' => true]);
        return $response;
    }

    public function delete(Request $request, Response $response, $args) {
        $this->requireAuthentication($request, $response);

        try {
            $this->authService->delete($args['username']);
        } catch (UnknownCredentialsException $e) {
            $response = $response->withJson(['error' => 'Unknown user'])->withStatus(409);
            return $response;
        }

        $response = $response->withJson(['success' => true]);
        return $response;
    }
}