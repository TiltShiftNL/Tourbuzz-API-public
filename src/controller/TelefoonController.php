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

        if (!isset($post['language']) || !in_array($post['language'],['nl','en', 'de'])) {
            $response = $response->withStatus(406)->withJson(['error' => 'No or invalid language, expecting nl|en|de']);
            return $response;
        }

        $em           = $this->ci->get('em');
        $telefoonRepo = $em->getRepository('App\Entity\Telefoon');
        $telefoon     = $telefoonRepo->findOneByNumber($post['number']);

        if (null === $telefoon) {
            $telefoon = new Telefoon();
            $telefoon->setNumber($post['number']);
            $date = new \DateTime();
            $telefoon->setCreated($date);
            $em->persist($telefoon);
        }

        $telefoon->setLanguage(strtolower($post['language']));
        $em->flush();
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