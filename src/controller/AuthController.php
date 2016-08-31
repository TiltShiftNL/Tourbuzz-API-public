<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthController {
    protected $ci;
    //Constructor
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function transform(Request $request, Response $response, $args) {

    }
}