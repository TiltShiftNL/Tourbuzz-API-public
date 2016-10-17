<?php

namespace App\Controller;

use App\Exception\MailExistsException;
use App\Exception\NoMailException;
use App\Mapper\MailMapper;
use App\Service\MailService;
use Slim\Http\Request;
use Slim\Http\Response;

class MailController extends Controller {

    /**
     * @var MailService
     */
    protected $mailService;

    public function __construct(\Interop\Container\ContainerInterface $ci)
    {
        $this->mailService = $ci->get('mail');
        parent::__construct($ci);
    }

    public function register(Request $request, Response $response, $args) {
        $post = $request->getParsedBody();

        if (!isset($post['mail']) || !isset($post['language'])) {
            $response = $response->withStatus(405)->withJson(['error' => 'No mail or language']);
            return $response;
        }

        $mail = strtolower($post['mail']);

        $name = isset($post['name']) ? $post['name'] : null;
        $organisation = isset($post['organisation']) ? $post['organisation'] : null;

        try {
            $this->mailService->register($mail, $post['language'], $name, $organisation);
        } catch (MailExistsException $e) {
            $response = $response->withStatus(406)->withJson(['error' => 'Mail exists']);
            return $response;

        }
        return $response;
    }

    public function confirm(Request $request, Response $response, $args) {
        $response = $response->withJson(['confirmed' => $this->mailService->confirm($args['token'])]);
        return $response;
    }

    public function unsubscribe(Request $request, Response $response, $args) {
        $post = $request->getParsedBody();

        if (!isset($post['mail'])) {
            $response = $response->withStatus(405)->withJson(['error' => 'No mail']);
            return $response;
        }


        $mail = strtolower($post['mail']);

        try {
            $this->mailService->unsubscribe($mail);
        } catch (NoMailException $e) {
            $response = $response->withStatus(406)->withJson(['error' => 'No mail']);
            return $response;

        }

        return $response;
    }

    public function unsubscribeConfirm(Request $request, Response $response, $args) {
        $response = $response->withJson(['unsubscribed' => $this->mailService->unsubscribeConfirm($args['token'])]);
        return $response;
    }

    public function index(Request $request, Response $response, $args) {
        $r = $this->requireAuthentication($request, $response);
        if (null !== $r) {
            return $r;
        }

        $response = $response->withJson(MailMapper::mapCollection($this->mailService->getAll()));
        return $response;
    }
}