<?php

namespace App\View\Mail;

use App\Custom\Response;
use App\Entity\User;
use Slim\Views\Twig;

class ForgotPasswordMail {

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var Twig
     */
    protected $view;

    public function __construct($settings, $user, $url, $token, $view) {
        $this->settings = $settings;
        $this->user     = $user;
        $this->url      = $url;
        $this->token    = $token;
        $this->view     = $view;
    }

    public function send() {
        $link = $this->url . $this->token;

        $from = new \SendGrid\Email('Tour Buzz', $this->settings['fromMail']);
        $to = new \SendGrid\Email($this->user->getUsername(), $this->user->getMail());

        $response = new Response();
        $content = new \SendGrid\Content("text/plain", $this->view->render($response, 'forgotPassword.twig',
            [
                'username' => $this->user->getUsername(),
                'link'     => $link
            ])->getBody()->__toString());


        $mail = new \SendGrid\Mail(
            $from,
            'Tour Buzz - Wachtwoord vergeten',
            $to,
            $content);

        $sg = new \SendGrid($this->settings['sendgridApiKey']);
        $response = $sg->client->mail()->send()->post($mail);
    }
}