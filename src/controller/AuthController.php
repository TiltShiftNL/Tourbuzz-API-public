<?php

namespace App\Controller;

use App\Exception\NotAuthenticatedException;
use App\Exception\UnknownCredentialsException;
use App\Service\AuthService;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller {
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function login(Request $request, Response $response, $args) {
        $post = $request->getParsedBody();
        if (!isset($post['username']) || !isset($post['password'])) {
            $response = $response->withStatus(401);
            return $response;
        }

        try {
            $token = $this->authService->login($post['username'], $post['password']);
        } catch (UnknownCredentialsException $e) {
            $response = $response->withStatus(401);
            return $response;
        }

        $response = $response->withJson(['token' => $token->getToken()]);
        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function logout(Request $request, Response $response, $args) {
        $this->requireAuthentication($request, $response);

        $get = $request->getQueryParams();
        $token = $this->authService->getToken($get['token']);

        if (null !== $token) {
            $this->authService->deleteToken($token);
        }

        return $response;
    }

    public function token(Request $request, Response $response, $args) {
        $get = $request->getQueryParams();
        if (!isset($get['token'])) {
            $response = $response->withStatus(400);
            return $response;
        }

        $token = $this->authService->getToken($get['token']);
        if (null === $token) {
            $response = $response->withStatus(404);
            return $response;
        }

        $response = $response->withJson([
            'username' => $token->getUser()->getUsername(),
            'expires'  => $this->authService->getExpires($token)
        ]);

        return $response;
    }
}