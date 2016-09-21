<?php

namespace App\View\Mail;

use App\Entity\Mail;

class RegisterMail {

    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @var array
     */
    protected $settings;

    public function __construct(Mail $mail, $settings) {
        $this->mail     = $mail;
        $this->settings = $settings;
    }

    public function send() {
        switch ($this->mail->getLanguage()) {
            case 'en':
                $params = $this->getEnParams();
                break;
            default:
                $params = $this->getNlParams();
                break;

        }

        $this->sendMail($params);
    }

    protected function sendMail($params) {
        $transport = \Swift_SmtpTransport::newInstance($this->settings['smtpServer'], $this->settings['smtpPort'], $this->settings['smtpEncryption'])
            ->setUsername($this->settings['smtpUsername'])
            ->setPassword($this->settings['smtpPassword']);
        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance($params['subject'])
            ->setFrom([$this->settings['smtpUsername'] => $params['from']])
            ->setTo([$this->mail->getMail()])
            ->setBody($params['body'])
        ;

        $mailer->send($message);
    }

    protected function getNlParams() {
        $params = [];
        $params['subject'] = 'Mailbrief tourbuzz.nl bevestigen';
        $params['from']    = 'Tourbuzz.nl';

        $naam = null !== $this->mail->getName() ? ' ' . $this->mail->getName() : '';
        $link = $this->settings['mailConfirmUrl'] . $this->mail->getConfirmUUID();
        $params['body']    = <<<EOT
Geachte$naam,

Klik op de onderstaande link om uw aanmelding voor de tourbuzz nieuwsbrief te bevestigen.

$link

Op deze mail kunt u niet reageren.

Groet,

Tourbuzz.nl

EOT;
        return $params;
    }

    protected function getEnParams() {
        $params = [];
        $params['subject'] = 'Confirm tourbuzz.nl newsletter';
        $params['from']    = 'Tourbuzz.nl';

        $naam = null !== $this->mail->getName() ? $this->mail->getName() : 'Sir / Madam';
        $link = $this->settings['mailConfirmUrl'] . $this->mail->getConfirmUUID();
        $params['body']    = <<<EOT
Dear $naam,

Click on the link below to confirm your subscription on the tourbuzz.nl newsletter.

$link

You can't respond to this message.

Tourbuzz.nl

EOT;
        return $params;
    }
}