<?php

namespace App\Controller;

use App\Mapper\BerichtMapper;

class BerichtenController {
    protected $ci;
    //Constructor
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function index($request, $response, $args) {
        $date = date("Y-m-d");

        /**
         * @var \Doctrine\ORM\EntityManager $em;
         */
        $em = $this->ci->get('em');
        $repo =  $em->getRepository('App\Entity\Bericht');

        $berichten = $repo->findAll();


        $mappedBerichten = BerichtMapper::mapCollection($berichten);

        // If link is available, and it is a link to google maps
        // Get location geo information.
        $messages = array_map(function ($message) {
            $message->link_info = "";
            $message->location = (object)[];
            if (!empty($message->location_lat) && !empty($message->location_lng)) {
                $message->location = [
                    "lat" => $message->location_lat,
                    "lng" => $message->location_lng
                ];
            }
            return $message;
        }, $messages);

        $uriParts = array_values(array_filter(explode("/", explode("?", $_SERVER["REQUEST_URI"])[0])));

        // If message id is present (40 char length)
        // Get One and Exit.
        if (!empty($uriParts[1]) && strlen($uriParts[1]) === 40) {
            $id = $uriParts[1];
            if (!array_key_exists($id, $messages)) {
                header("HTTP/1.1 404 Not Found");
                exit;
            }
            $message = $messages[$id];
            header("Content-type: application/json");
            echo json_encode([
                "message" => $message
            ]);
            exit;
        }

        // Filter by date.
        if (!empty($uriParts[1]) && strlen($uriParts[1]) === 4) {
            $date = "{$uriParts[1]}-{$uriParts[2]}-{$uriParts[3]}";
            $messages = array_filter($messages, function ($message) use ($date) {
                return $message->startdate <= $date &&
                $message->enddate >= $date;
            });
        }

        // Sort messages by date.
        uasort($messages, function ($messageA, $messageB) {
            return $messageA->startdate > $messageB->startdate;
        });

        header("Content-type: application/json");
        echo json_encode([
            "_date" => $date,
            "_nextDate" => date("Y-m-d", strtotime("+1 day", strtotime($date))),
            "_prevDate" => date("Y-m-d", strtotime("-1 day", strtotime($date))),
            "_timestamp" => date("Y-m-d", filemtime($filePath)),
            "messages" => $messages
        ]);
        exit;
    }
}