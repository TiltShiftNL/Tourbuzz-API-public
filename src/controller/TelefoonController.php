<?php

namespace App\Controller;

use App\Entity\Telefoon;
use App\Mapper\TelefoonMapper;
use Slim\Http\Request;
use Slim\Http\Response;

class TelefoonController extends Controller {

    public function __construct(\Interop\Container\ContainerInterface $ci)
    {
        parent::__construct($ci);
    }

    public function register(Request $request, Response $response, $args) {
        $post = $request->getParsedBody();

        if (!isset($post['number'])) {
            $response = $response->withStatus(405)->withJson(['error' => 'No number']);
            return $response;
        }

        if (!isset($post['country']) || !in_array($post['country'],['nl','en'])) {
            $response = $response->withStatus(405)->withJson(['error' => 'No or invalid country, expecting nl|en']);
            return $response;
        }

        $em           = $this->ci->get('em');
        $telefoonRepo = $em->getRepository('App\Entity\Telefoon');
        $telefoon     = $telefoonRepo->findOneByNumber($post['number']);

        if (null === $telefoon) {
            $telefoon = new Telefoon();
            $telefoon->setNumber($post['number']);
            $telefoon->setCountry(strtolower($post['country']));
            $date = new \DateTime();
            $telefoon->setCreated($date);
            $em->persist($telefoon);
            $em->flush();
        }
    }

    public function unsubscribe(Request $request, Response $response, $args) {
        $post = $request->getParsedBody();

        if (!isset($post['number'])) {
            $response = $response->withStatus(405)->withJson(['error' => 'No number']);
            return $response;
        }

        $em           = $this->ci->get('em');
        $telefoonRepo = $em->getRepository('App\Entity\Telefoon');
        $telefoon     = $telefoonRepo->findOneByNumber($post['number']);

        if (null !== $telefoon) {
            $em->remove($telefoon);
            $em->flush();
        }

        return $response;
    }

    public function index(Request $request, Response $response) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        $em           = $this->ci->get('em');
        $telefoonRepo = $em->getRepository('App\Entity\Telefoon');
        $telefoon     = $telefoonRepo->findAll();

        $response = $response->withJson(TelefoonMapper::mapCollection($telefoon));
        return $response;
    }
}