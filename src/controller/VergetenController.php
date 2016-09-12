<?php

namespace App\Controller;

use App\Exception\InvalidCredentialsException;
use App\Exception\UnknownCredentialsException;
use App\Mapper\UserMapper;
use Slim\Http\Request;
use Slim\Http\Response;

class VergetenController extends Controller {

    public function vergeten(Request $request, Response $response, $args) {
        $post = $request->getParsedBody();
        if (!isset($post['username'])) {
            $response = $response = $response = $response->withStatus(404);
            return $response;
        }

        $this->authService->sendForgotLink($post['username']);
    }

    public function checkToken(Request $request, Response $response, $args) {
        $user = $this->authService->checkVergetenToken($args['token']);

        if (null === $user) {
            $response = $response->withStatus(404);
            return $response;
        }

        $mappedUser = UserMapper::mapSingle($user);
        $response = $response->withJson($mappedUser);
        return $response;
    }

    public function changePasswordByToken(Request $request, Response $response, $args) {
        $post = $request->getParsedBody();
        try {
            $this->authService->changePasswordByVergetenToken($post['token'], $post['password']);
        } catch (UnknownCredentialsException $e) {
            $response = $response->withStatus(403)->withJson(['error' => 'invalid token']);
            return $response;
        } catch (InvalidCredentialsException $e) {
            $response = $response->withStatus(405)->withJson(['error' => 'password length']);
            return $response;
        }
    }
}