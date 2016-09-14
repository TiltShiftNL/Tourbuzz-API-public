<?php

namespace App\View\Mail;

use App\Entity\Bericht;
use App\Entity\Mail;

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
     * @var Bericht[] $berichten
     */
    protected $berichten;

    /**
     * @var array $sortedByDate
     */
    protected $sortedByDate;

    /**
     * NewsletterMail constructor.
     * @param Mail $mail
     * @param Bericht[] $berichten
     * @param array $sortedByDate
     * @param $settings
     */
    public function __construct(Mail $mail, $berichten, $sortedByDate, $settings) {
        $this->mail         = $mail;
        $this->settings     = $settings;
        $this->berichten    = $berichten;
        $this->sortedByDate = $sortedByDate;
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

    /**
     * @param array $params
     */
    protected function sendMail($params) {
        $transport = \Swift_SmtpTransport::newInstance($this->settings['smtpServer'], $this->settings['smtpPort'], 'tls')
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

    /**
     * @return array
     */
    protected function getNlParams() {
        $params = [];
        $params['subject'] = 'Mailbrief tourbuzz.nl';
        $params['from']    = 'Tourbuzz.nl';

        $naam = null !== $this->mail->getName() ? ' ' . $this->mail->getName() : '';

        $berichten = '';
        foreach ($this->berichten as $datum => $arr) {
            $berichten .= "\n\n" . $datum . "\n\n";
            foreach ($arr as $bericht) {
                /**
                 * @var Bericht $bericht
                 */
                $berichten .= $bericht->getStartDate()->format('d-m-Y') . ' - ' . $bericht->getEndDate()->format('d-m-Y') . ' ' . $bericht->getTitle() . "\n";
            }
        }

        $params['body']    = <<<EOT
Geachte$naam,

Hierbij de merkwaardigheden voor de komende twee weken.

$berichten

Groet,

Tourbuzz.nl

EOT;
        return $params;
    }

    /**
     * @return array
     */
    protected function getEnParams() {
        $params = [];
        $params['subject'] = 'Confirm tourbuzz.nl newsletter';
        $params['from']    = 'Tourbuzz.nl';

        $naam = null !== $this->mail->getName() ? $this->mail->getName() : 'Sir / Madam';


        $berichten = '';
        foreach ($this->berichten as $datum => $arr) {
            $berichten .= "\n\n" . $datum . "\n\n";
            foreach ($arr as $bericht) {
                /**
                 * @var Bericht $bericht
                 */
                $berichten .= $bericht->getStartDate()->format('d-m-Y') . ' - ' . $bericht->getEndDate()->format('d-m-Y') . ' ' . $bericht->getTitleEn() . "\n";
            }
        }

        $params['body']    = <<<EOT
Dear $naam,

These are the noteworthy events in the comming two weeks.
$berichten

You can't respond to this message.

Tourbuzz.nl

EOT;
        return $params;
    }
}