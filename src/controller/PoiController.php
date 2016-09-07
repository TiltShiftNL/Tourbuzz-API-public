<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class PoiController {
    protected $ci;
    //Constructor
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function index(Request $request, Response $response, $args) {
        header("Content-type: application/x-download");
        header("Content-Disposition: attachment; filename=touringcar.csv");
        header("Content-Transfer-Encoding: binary");

        $json = file_get_contents("http://api.tourbuzz.nl/haltes/");
        $rs = json_decode($json);
        foreach ($rs->haltes as $halte) {
            $halte->naam = isset($halte->naam) ? str_replace(",", "/", $halte->naam) : '';
            $response->write("{$halte->location->lng},{$halte->location->lat},{$halte->haltenummer},halte\n");
        }

        $json = file_get_contents("http://api.tourbuzz.nl/parkeerplaatsen/");
        $rs = json_decode($json);
        foreach ($rs->parkeerplaatsen as $parkeerplaats) {
            if (!$parkeerplaats->naam) $parkeerplaats->naam = $parkeerplaats->nummer;
            $parkeerplaats->naam = str_replace(",", "/", $parkeerplaats->naam);
            $response->write("{$parkeerplaats->location->lng},{$parkeerplaats->location->lat},{$parkeerplaats->naam},parkeerplaats\n");
        }

        $response = $response
            ->withHeader('Content-type', 'application/x-download')
            ->withHeader('Content-Disposition', 'attachment; filename=touringcar.csv')
            ->withHeader('Content-Transfer-Encoding', 'binary');
        return $response;
    }
}