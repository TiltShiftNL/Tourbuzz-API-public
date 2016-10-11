<?php

namespace App\View\Mail;

use App\Custom\Response;
use App\Entity\Bericht;
use App\Entity\User;
use Slim\Views\Twig;

class CreateBerichtMail {

    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var Bericht
     */
    protected $bericht;

    /**
     * @var User
     */
    protected $createUser;

    /**
     * CreateBerichtMail constructor.
     * @param $settings
     * @param $user
     * @param $url
     * @param $bericht
     * @param $createUser
     * @param $view
     */
    public function __construct($settings, $user, $bericht, $createUser, $view) {
        $this->settings   = $settings;
        $this->user       = $user;
        $this->view       = $view;
        $this->bericht    = $bericht;
        $this->createUser = $createUser;
    }

    public function send() {
        $from = new \SendGrid\Email('Tour Buzz', $this->settings['fromMail']);
        $to = new \SendGrid\Email($this->user->getUsername(), $this->user->getMail());

        $response = new Response();
        $content = new \SendGrid\Content("text/plain", $this->view->render($response, 'createBericht.twig',
            [
                'username' => $this->user->getUsername(),
                'createUsername' => $this->createUser->getUsername(),
                'titel'    => $this->bericht->getTitle()
            ])->getBody()->__toString());


        $mail = new \SendGrid\Mail(
            $from,
            'Tour Buzz - Bericht aanmaak melding',
            $to,
            $content);

        $sg = new \SendGrid($this->settings['sendgridApiKey']);
        $response = $sg->client->mail()->send()->post($mail);
    }
}