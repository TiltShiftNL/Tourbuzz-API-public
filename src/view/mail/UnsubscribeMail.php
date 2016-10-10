<?php

namespace App\View\Mail;

use App\Custom\Response;
use App\Entity\Mail;
use Slim\Views\Twig;

class UnsubscribeMail {

    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var Twig
     */
    protected $view;

    /**
     * UnsubscribeMail constructor.
     * @param Mail $mail
     * @param $settings
     * @param $view
     */
    public function __construct(Mail $mail, $settings, $view) {
        $this->mail     = $mail;
        $this->settings = $settings;
        $this->view     = $view;
    }

    public function send() {
        switch ($this->mail->getLanguage()) {
            case 'en':
                $params = $this->getEnParams();
                break;
            case 'de':
                $params = $this->getDeParams();
                break;
            case 'es':
                $params = $this->getEsParams();
                break;
            default:
                $params = $this->getNlParams();
                break;

        }

        $this->sendMail($params);
    }

    protected function sendMail($params) {
        $from = new \SendGrid\Email('Tour Buzz', $this->settings['fromMail']);
        $to = new \SendGrid\Email($this->mail->getName(), $this->mail->getMail());

        $content = new \SendGrid\Content("text/plain", $params['body']);

        $mail = new \SendGrid\Mail(
            $from,
            $params['subject'],
            $to,
            $content);

        $sg = new \SendGrid($this->settings['sendgridApiKey']);
        $response = $sg->client->mail()->send()->post($mail);
    }

    protected function getNlParams() {
        $params = [];
        $params['subject'] = 'Tour Buzz berichtservice annuleren';
        $params['from']    = 'Tour Buzz';

        $naam = null !== $this->mail->getName() ? ' ' . $this->mail->getName() : '';
        $link = $this->settings['mailUnsubscribeUrl'] . $this->mail->getUnsubscribeUUID();
        $response = new Response();
        $params['body'] = $this->view->render($response, 'unsubscribe.nl.twig',
            [
                'naam' => $naam,
                'link' => $link
            ])->getBody()->__toString();
        return $params;
    }

    protected function getEnParams() {
        $params = [];
        $params['subject'] = 'Cancel Tour Buzz message service';
        $params['from']    = 'Tour Buzz';

        $naam = null !== $this->mail->getName() ? $this->mail->getName() : 'Sir / Madam';
        $link = $this->settings['mailUnsubscribeUrl'] . $this->mail->getUnsubscribeUUID();
        $response = new Response();
        $params['body'] = $this->view->render($response, 'unsubscribe.en.twig',
            [
                'naam' => $naam,
                'link' => $link
            ])->getBody()->__toString();
        return $params;
    }

    protected function getDeParams() {
        $params = [];
        $params['subject'] = 'Beenden Tour Buzz message service';
        $params['from']    = 'Tour Buzz';

        $naam = null !== $this->mail->getName() ? $this->mail->getName() : 'Sir / Madam';
        $link = $this->settings['mailUnsubscribeUrl'] . $this->mail->getUnsubscribeUUID();
        $response = new Response();
        $params['body'] = $this->view->render($response, 'unsubscribe.de.twig',
            [
                'naam' => $naam,
                'link' => $link
            ])->getBody()->__toString();
        return $params;
    }

    protected function getEsParams() {
        $params = [];
        $params['subject'] = 'Cancel Tour Buzz message service';
        $params['from']    = 'Tour Buzz';

        $naam = null !== $this->mail->getName() ? $this->mail->getName() : 'Sir / Madam';
        $link = $this->settings['mailUnsubscribeUrl'] . $this->mail->getUnsubscribeUUID();
        $response = new Response();
        $params['body'] = $this->view->render($response, 'unsubscribe.es.twig',
            [
                'naam' => $naam,
                'link' => $link
            ])->getBody()->__toString();
        return $params;
    }
}