<?php

namespace App\Controller;

use App\Mapper\UserMapper;
use Slim\Http\Request;
use Slim\Http\Response;

class VergetenController extends Controller {

    public function vergeten(Request $request, Response $response, $args) {
        $post = $request->getParsedBody();
        if (!isset($post['username'])) {
            $response = $response = $response->withStatus(406);
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
}