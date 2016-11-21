<?php

namespace App\Controller;

use App\Entity\VialisDynamicRepo;
use App\Mapper\VialisDynamicMapper;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Slim\Http\Response;

class VialisController extends Controller {

    public function index(Request $request, Response $response, $args)
    {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        /**
         * @var EntityManager $em
         */
        $em  = $this->ci->get('em');

        /**
         * @var VialisDynamicRepo $repo
         */
        $repo = $em->getRepository('App\Entity\VialisDynamic');

        $dynamics = $repo->findAll();

        $mappedBerichten = VialisDynamicMapper::mapCollection($dynamics);

        $response = $response->withStatus(200)->withJson($mappedBerichten);

        return $response;
    }
}