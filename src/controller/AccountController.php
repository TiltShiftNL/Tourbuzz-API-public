<?php

namespace App\Controller;

use App\Exception\InvalidCredentialsException;
use App\Exception\UnknownCredentialsException;
use App\Exception\UsernameExistsException;
use App\Mapper\UserMapper;
use Slim\Http\Request;
use Slim\Http\Response;

class AccountController extends Controller {

    public function create(Request $request, Response $response, $args) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        $post = $request->getParsedBody();
        if (!isset($post['username']) || !isset($post['password'])  || !isset($post['mail'])) {
            $response = $response = $response->withStatus(406);
            return $response;
        }

        $create_notifications = !isset($post['create_notifications']) && true === $post['create_notifications'] ? true : false;

        try {
            $this->authService->create($post['username'], $post['password'], $post['mail'], $create_notifications);
        } catch (UsernameExistsException $e) {
            $response = $response->withJson(['error' => 'username exists'])->withStatus(409);
            return $response;
        } catch (InvalidCredentialsException $e) {
            $response = $response->withJson(['error' => 'invalid credentials'])->withStatus(407);
            return $response;
        }

        $response = $response->withJson(['success' => true]);
        return $response;
    }

    public function index(Request $request, Response $response, $args) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        $users = $this->authService->getAllUsers();

        $mappedUsers = UserMapper::mapCollection($users);

        $response = $response->withJson($mappedUsers);
        return $response;
    }

    public function single(Request $request, Response $response, $args) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }
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
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        $post = $request->getParsedBody();
        if (!isset($post['username']) || !isset($post['mail'])) {
            $response = $response = $response->withStatus(406);
            return $response;
        }

        $create_notifications = !isset($post['create_notifications']) && true === $post['create_notifications'] ? true : false;
        $password = isset($post['password']) ? $post['password'] : null;

        try {
            $this->authService->update($post['username'], $password, $post['mail'], $create_notifications);
        } catch (UnknownCredentialsException $e) {
            $response = $response->withJson(['error' => 'Unknown user'])->withStatus(409);
            return $response;
        } catch (InvalidCredentialsException $e) {
            $response = $response->withJson(['error' => 'invalid credentials'])->withStatus(407);
            return $response;
        }

        $response = $response->withJson(['success' => true]);
        return $response;
    }

    public function delete(Request $request, Response $response, $args) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

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