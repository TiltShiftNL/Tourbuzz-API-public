<?php

namespace App\Controller;

use App\Exception\MailExistsException;
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

        $name = isset($post['name']) ? $post['name'] : null;

        try {
            $this->mailService->register($post['mail'], $post['language'], $name);
        } catch (MailExistsException $e) {
            $response = $response->withStatus(406)->withJson(['error' => 'Mail exists']);
            return $response;

        }
        return $response;
    }
}