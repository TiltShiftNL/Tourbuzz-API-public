<?php

namespace App\Controller;

use App\Service\VialisService;
use Slim\Http\Request;

class ParkeerController {
    protected $ci;
    //Constructor
    public function __construct(\Psr\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function index(Request $request, $response, $args) {


        $settings = $this->ci->get('settings');

        if (!isset($settings['parkeerUrl'])) {
            throw new \Exception('Missing parkeerUrl in settings.php');
        }

        if (!isset($settings['messagesUrl'])) {
            throw new \Exception('Missing messagesUrl in settings.php');
        }

        $guzzle = new \GuzzleHttp\Client();

        try {
            $res = $guzzle->request('GET', $settings['parkeerUrl']);
            $jsonData = json_decode($res->getBody());
        } catch (\Exception $e) {
            $this->ci->get('logger')->error('Exception while loading parkeerInfo from datasource', [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            header("HTTP/1.1 404 Not Found");
            exit;
        }

        $disabled = [];
        try {
            $res = $guzzle->request('GET', $settings['messagesUrl']);
            $messages = json_decode($res->getBody());
            foreach ($messages->messages as $msg) {
                if ($msg->is_live && preg_match("/((P|p)[0-9]{1,2}).* niet beschikbaar/", $msg->title, $matches)) {
                    $disabled[$matches[1]] = $matches[1];
                }
            }
        } catch (\Exception $e) {
            $this->ci->get('logger')->warning('Exception while loading parkeerInfo from datasource', [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            // void ignore
        }

        $result = [
            "_datum" => date("Y-m-d"),
            "_uri" => $args,
            "_bron" => $settings['parkeerUrl'],
            "_pogingen" => 0,
        ];

        /**
         * @var VialisService $vialis
         */
        $vialis = $this->ci->get('vialis');

        foreach ($jsonData->parkeerplaatsen as $data) {
            $data = $data->parkeerplaats;
            $titleParts = explode(":", $data->title);
            $geoJson = json_decode($data->Lokatie);
            $mapsImageUrl = "https://maps.googleapis.com/maps/api/staticmap?center={$geoJson->coordinates[1]},{$geoJson->coordinates[0]}&zoom=16&size=600x300&maptype=roadmap&markers={$geoJson->coordinates[1]},{$geoJson->coordinates[0]}&key=AIzaSyA_o88ovC0-TE8YyYqtIXFQIkRPeJX2VKU";
            $mapsUrl = "https://www.google.com/maps/?q=loc:{$geoJson->coordinates[1]},{$geoJson->coordinates[0]}";
            $nummer = array_shift($titleParts);
            if (!preg_match('/^P[0-9]{1,2}$/', $nummer)) continue;
            $parkeerplaats = (object) [
                "nummer" => $nummer,
                "naam" => trim(array_shift($titleParts)),
                "capaciteit" => intval(str_replace("maximaal ", "", $data->Busplaatsen)),
                "location" => [
                    "lat" => $geoJson->coordinates[1],
                    "lng" => $geoJson->coordinates[0]
                ],
                "mapsImageUrl" => $mapsImageUrl,
                "mapsUrl" => $mapsUrl,
                "beschikbaar" => empty($disabled[$nummer]),
                "vialis" => $vialis->getForParkeerplaats($nummer),
                "_origineel" => $data
            ];
            if (isset($args['id']) && !empty($args['id'])) {
                if (strtolower($parkeerplaats->nummer) !== strtolower($args['id'])) {
                    continue;
                } else {
                    $result["parkeerplaats"] = $parkeerplaats;
                    break;
                }
            } else {
                $result["parkeerplaatsen"][$parkeerplaats->nummer] = $parkeerplaats;
            }
        }

        if (isset($result["parkeerplaatsen"])) {
            uksort($result["parkeerplaatsen"], function ($a, $b) {
                return (int)substr($a, 1) > (int)substr($b, 1);
            });
        }


        $response = $response
            ->withStatus(200)
            ->withJson($result);

        return $response;

    }
}