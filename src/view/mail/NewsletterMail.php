<?php

namespace App\View\Mail;

use App\Custom\Response;
use App\Entity\Bericht;
use App\Entity\Mail;
use SendGrid\Personalization;
use Slim\Views\Twig;

class NewsletterMail {

    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var Bericht[]
     */
    protected $berichten;

    /**
     * @var array
     */
    protected $sortedByDate;

    /**
     * @var Twig
     */
    protected $view;

    /**
     * NewsletterMail constructor.
     * @param Mail $mail
     * @param Twig $view
     * @param Bericht[] $berichten
     * @param array $sortedByDate
     * @param array $settings
     */
    public function __construct(Mail $mail, $view, $berichten, $sortedByDate, $settings) {
        $this->mail         = $mail;
        $this->settings     = $settings;
        $this->berichten    = $berichten;
        $this->sortedByDate = $sortedByDate;
        $this->view         = $view;
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

        $from = new \SendGrid\Email($params['from'], $this->settings['fromMail']);

        $to = new \SendGrid\Email($this->mail->getName(), $this->mail->getMail());


        $mail = new \SendGrid\Mail();
        $mail->setFrom($from);
        $mail->setSubject($params['subject']);
        $personalization = new Personalization();
        $personalization->addTo($to);
        $mail->addPersonalization($personalization);

        $plainContent = new \SendGrid\Content("text/plain", $params['part']);
        $htmlContent = new \SendGrid\Content("text/html", $params['body']);
        $mail->addContent($plainContent);
        $mail->addContent($htmlContent);

        $attachment = new \Sendgrid\Attachment();
        $attachment->setContent(base64_encode(file_get_contents('src/view/mail/images/GASD_1.png')));
        $attachment->setType('png');
        $attachment->setFilename('GASD_1.png');
        $attachment->setDisposition('inline');
        $attachment->setContentID('logo-cid');


        $mail->addAttachment($attachment);

        $sg = new \SendGrid($this->settings['sendgridApiKey']);

        $response = $sg->client->mail()->send()->post($mail);
    }

    /**
     * @return array
     */
    protected function getNlParams() {
        $params = [];
        $params['subject'] = 'Tour Buzz Berichtenservice';
        $params['from']    = 'Tour Buzz';

        $response = new Response();
        $params['part'] = $this->view->render($response, 'newsletter.nl.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ])->getBody()->__toString();

        $response = new Response();
        $params['body'] = $this->view->render($response, 'newsletter.nl.html.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ])->getBody()->__toString();

        return $params;
    }

    /**
     * @return array
     */
    protected function getEnParams() {
        $params = [];
        $params['subject'] = 'Tour Buzz messageservice';
        $params['from']    = 'Tourbuzz.nl';

        $response = new Response();
        $params['part'] = $this->view->render($response, 'newsletter.en.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ])->getBody()->__toString();

        $response = new Response();
        $params['body'] = $this->view->render($response, 'newsletter.en.html.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ])->getBody()->__toString();
        return $params;
    }

    /**
     * @return array
     */
    protected function getDeParams() {
        $params = [];
        $params['subject'] = 'Tour Buzz messageservice';
        $params['from']    = 'Tourbuzz.nl';

        $response = new Response();
        $params['part'] = $this->view->render($response, 'newsletter.de.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ])->getBody()->__toString();

        $response = new Response();
        $params['body'] = $this->view->render($response, 'newsletter.de.html.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ])->getBody()->__toString();
        return $params;
    }

    /**
     * @return array
     */
    protected function getEsParams() {
        $params = [];
        $params['subject'] = 'Tour Buzz messageservice';
        $params['from']    = 'Tourbuzz.nl';

        $response = new Response();
        $params['part'] = $this->view->render($response, 'newsletter.es.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ])->getBody()->__toString();

        $response = new Response();
        $params['body'] = $this->view->render($response, 'newsletter.es.html.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ])->getBody()->__toString();
        return $params;
    }
}