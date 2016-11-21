<?php

namespace App\Controller;

use App\Entity\VialisDynamicRepo;
use App\Mapper\VialisDynamicMapper;
use App\Service\VialisService;
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

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function map(Request $request, Response $response) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        $post = $request->getParsedBody();
        if (!isset($post['parkeerplaats']) || !isset($post['id'])) {
            $response = $response->withStatus(401);
            return $response;
        }

        /**
         * @var VialisService $vialis
         */
        $vialis = $this->ci->get('vialis');

        $return = $vialis->map($post['parkeerplaats'], $post['id']);

        if (!$return) {
            $response = $response->withStatus(406)->withJson(['error'=>'Onbekend vialis id']);
        }

        return $response;
    }
}