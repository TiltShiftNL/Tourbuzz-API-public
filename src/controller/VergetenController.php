<?php

namespace App\Controller;

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
}