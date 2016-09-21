<?php

namespace App\View\Mail;

use App\Custom\Response;
use App\Entity\Bericht;
use App\Entity\Mail;
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

        $transport = \Swift_SmtpTransport::newInstance($this->settings['smtpServer'], $this->settings['smtpPort'], $this->settings['smtpEncryption'])
            ->setUsername($this->settings['smtpUsername'])
            ->setPassword($this->settings['smtpPassword']);
        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance();

        switch ($this->mail->getLanguage()) {
            case 'en':
                list($message, $params) = $this->getEnParams($message);
                break;
            default:
                list($message, $params) = $this->getNlParams($message);
                break;

        }

        $message->setSubject($params['subject'])
                ->setFrom([$this->settings['smtpUsername'] => $params['from']])
                ->setTo([$this->mail->getMail()])
                ->setBody($params['body'], 'text/html')
                ->addPart($params['part'], 'text/plain');

        $mailer->send($message);
    }

    /**
     * @return array
     */
    protected function getNlParams(\Swift_Message $message) {
        $params = [];
        $params['subject'] = 'Mailbrief tourbuzz.nl';
        $params['from']    = 'Tourbuzz.nl';

        $response = new Response();
        $params['part'] = $this->view->render($response, 'newsletter.nl.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ]);

        $response = new Response();
        $params['body'] = $this->view->render($response, 'newsletter.nl.html.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate,
                'image'        => $message->embed(\Swift_Image::fromPath('src/view/mail/images/GASD_1.png')->setDisposition('inline'))
            ]);

        return[$message, $params];
    }

    /**
     * @return array
     */
    protected function getEnParams($message) {
        $params = [];
        $params['subject'] = 'Confirm tourbuzz.nl newsletter';
        $params['from']    = 'Tourbuzz.nl';

        $response = new Response();
        $params['part'] = $this->view->render($response, 'newsletter.en.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate
            ]);

        $response = new Response();
        $params['body'] = $this->view->render($response, 'newsletter.en.html.twig',
            [
                'naam'         => $this->mail->getName(),
                'berichten'    => $this->berichten,
                'sortedByDate' => $this->sortedByDate,
                'image'        => $message->embed(\Swift_Image::fromPath('src/view/mail/images/GASD_1.png')->setDisposition('inline'))
            ]);
        return [$message, $params];
    }
}