<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class DistanceController {
    protected $ci;
    //Constructor
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function distance(Request $request, Response $response, $args) {
        $query = $request->getQueryParams();

        $response = $response->withJson([
            "distance" => $this->distCalc($query['lat1'], $query['lng1'], $query['lat2'], $query['lng2'])
        ]);
        return $response;
    }

    protected function distCalc($lat1, $lng1, $lat2, $lng2) {
        $R = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = pow(sin($dLat / 2), 2) + pow(sin($dLng / 2), 2) * cos(deg2rad($lat1)) * cos(deg2rad($lat2));
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $R * $c;
        return $d;
    }
}