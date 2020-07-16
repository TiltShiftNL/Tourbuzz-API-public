<?php

namespace App\Controller;

use Slim\Http\Request;

class HaltesController {
    protected $ci;
    //Constructor
    public function __construct(\Psr\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function index(Request $request, $response, $args) {


        $settings = $this->ci->get('settings');

        if (!isset($settings['haltesUrl'])) {
            throw new \Exception('Missing haltesUrl in settings.php');
        }

        if (!isset($settings['messagesUrl'])) {
            throw new \Exception('Missing messagesUrl in settings.php');
        }

        $guzzle = new \GuzzleHttp\Client();

        try {
            $res = $guzzle->request('GET', $settings['haltesUrl']);
            $jsonData = json_decode($res->getBody());
        } catch (\Exception $e) {
            $this->ci->get('logger')->error('Exception while loading haltes from datasource', [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'url' => $settings['haltesUrl']
            ]);
            header("HTTP/1.1 404 Not Found");
            exit;
        }

        $disabled = [];
        try {
            $res = $guzzle->request('GET', $settings['messagesUrl']);
            $messages = json_decode($res->getBody());
            foreach ($messages->messages as $msg) {
                if ($msg->is_live && preg_match("/((H|h)[0-9]{1,2}).* niet beschikbaar/", $msg->title, $matches)) {
                    $disabled[$matches[1]] = $matches[1];
                }
            }
        } catch (\Exception $e) {
            // void ignore
            $this->ci->get('logger')->warning('Exception while loading haltes (messages) from datasource', [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'url' => $settings['messagesUrl']
            ]);
        }

        $result = [
            "_datum" => date("Y-m-d"),
            "_uri" => $args,
            "_bron" => $settings['haltesUrl'],
            "_pogingen" => 0,
        ];

        foreach ($jsonData->in_uitstaphaltes as $data) {
            $data = $data->in_uitstaphalte;
            $titleParts = explode(":", $data->title);
            $haltenummer = array_shift($titleParts);
            if (!preg_match('/^H[0-9]{1,2}$/', $haltenummer)) continue;
            $straat = trim(array_shift($titleParts));
            $geoJson = json_decode($data->Lokatie);
            $locatie = trim($data->Bijzonderheden);
            $capaciteit = intval($data->Busplaatsen);
            $mapsImageUrl = "https://maps.googleapis.com/maps/api/staticmap?center={$geoJson->coordinates[1]},{$geoJson->coordinates[0]}&zoom=16&size=600x300&maptype=roadmap&markers={$geoJson->coordinates[1]},{$geoJson->coordinates[0]}&key=AIzaSyA_o88ovC0-TE8YyYqtIXFQIkRPeJX2VKU";
            $mapsUrl = "https://www.google.com/maps/?q=loc:{$geoJson->coordinates[1]},{$geoJson->coordinates[0]}";
            $halte = (object) [
                "haltenummer" => $haltenummer,
                "straat" => $straat,
                "locatie" => $locatie,
                "capaciteit" => $capaciteit,
                "location" => [
                    "lat" => $geoJson->coordinates[1],
                    "lng" => $geoJson->coordinates[0]
                ],
                "mapsImageUrl" => $mapsImageUrl,
                "mapsUrl" => $mapsUrl,
                "beschikbaar" => empty($disabled[$haltenummer]),
                "_origineel" => $data
            ];
            if (isset($args['id']) && !empty($args['id'])) {
                if (strtolower($haltenummer) !== strtolower($args['id'])) {
                    continue;
                } else {
                    $result["halte"] = $halte;
                    break;
                }
            } else {
                $result["haltes"][$halte->haltenummer] = $halte;
            }
        }

        if (isset($result['haltes'])) {
            uksort($result["haltes"], function ($a, $b) {
                return (int) substr($a, 1) > (int) substr($b, 1);
            });
        }

        $response = $response
            ->withStatus(200)
            ->withJson($result);

        return $response;

    }
}