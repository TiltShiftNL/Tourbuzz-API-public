<?php

namespace App\Controller;

use App\Entity\BerichtRepo;
use App\Mapper\BerichtMapper;
use Slim\Http\Request;

class BerichtenController {
    protected $ci;
    //Constructor
    public function __construct(\Interop\Container\ContainerInterface $ci) {
        $this->ci = $ci;
    }

    public function get(Request $request, $response, $args) {
        /**
         * @var \Doctrine\ORM\EntityManager $em;
         */
        $em = $this->ci->get('em');
        $repo =  $em->getRepository('App\Entity\Bericht');

        $bericht = $repo->findOneById($args['id']);

        header("Content-type: application/json");
        echo json_encode([
            "message" => BerichtMapper::mapSingle($bericht)
        ]);
    }

    public function index(Request $request, $response, $args) {
        $date = new \DateTime($args['jaar'] . '-' . $args['maand'] . '-' . $args['dag']);

        /**
         * @var \Doctrine\ORM\EntityManager $em;
         */
        $em = $this->ci->get('em');
        /**
         * @var BerichtRepo $repo;
         */
        $repo =  $em->getRepository('App\Entity\Bericht');

        $berichten = $repo->getByDate($date);

        $mappedBerichten = BerichtMapper::mapCollection($berichten);

        header("Content-type: application/json");
        echo json_encode([
            "_date" => $date->format('Y-m-d'),
            "_nextDate" => date("Y-m-d", strtotime("+1 day", strtotime($date->format('Y-m-d')))),
            "_prevDate" => date("Y-m-d", strtotime("-1 day", strtotime($date->format('Y-m-d')))),
            "messages" => $mappedBerichten
        ]);
    }
}