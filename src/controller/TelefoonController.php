<?php

namespace App\Controller;

use App\Entity\Telefoon;
use App\Service\Validate_NL;
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

        if (!Validate_NL::phoneNumber($post['number'],Validate_NL::VALIDATE_NL_PHONENUMBER_TYPE_MOBILE)) {
            $response = $response->withStatus(406)->withJson(['error' => 'No valid number']);
            return $response;
        }

        $em           = $this->ci->get('em');
        $telefoonRepo = $em->getRepository('App\Entity\Telefoon');
        $telefoon     = $telefoonRepo->findOneByNummer($post['number']);

        if (null === $telefoon) {
            $telefoon = new Telefoon();
            $telefoon->setNummer($post['number']);
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
        $telefoon     = $telefoonRepo->findOneByNummer($post['number']);

        if (null !== $telefoon) {
            $em->remove($telefoon);
            $em->flush();
        }

        return $response;
    }
}