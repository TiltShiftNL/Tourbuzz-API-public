<?php

namespace App\Service;

use App\Entity\Bericht;
use App\Entity\BerichtRepo;
use App\Entity\Mail;
use App\Entity\MailRepo;
use App\Exception\MailExistsException;
use App\Exception\NoMailException;
use App\View\Mail\NewsletterMail;
use App\View\Mail\RegisterMail;
use App\View\Mail\UnsubscribeMail;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

class MailService {


    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $ci;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var MailRepo
     */
    protected $mailRepo;

    /**
     * MailService constructor.
     * @param \Psr\Container\ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci) {
        $this->ci        = $ci;
        $this->em        = $this->ci->get('em');
        $this->mailRepo  = $this->em->getRepository('App\Entity\Mail');
    }

    /**
     * @param string $mail
     * @param string $name
     * @param string $language
     * @return bool
     * @throws MailExistsException
     */
    public function register($mail, $language, $name, $organisation) {
        /**
         * @var Mail $object
         */
        $object = $this->mailRepo->findOneByMail($mail);
        if (null !== $object) {
            if (null !== $object->getConfirmed()) {
                throw new MailExistsException();
            }
        }

        $uuid = Uuid::uuid4();
        $now = new \DateTime();

        $obj = null !== $object ? $object : new Mail();
        $obj->setMail($mail);
        $obj->setName($name);
        $obj->setOrganisation($organisation);
        $obj->setLanguage($language);
        $obj->setConfirmUUID($uuid->toString());
        $obj->setCreated($now);

        $this->em->persist($obj);
        $this->em->flush();

        $settings = $this->ci->get('settings');

        $registerMail = new RegisterMail($obj, $settings, $this->ci->get('mailView'));

        $registerMail->send();
        return true;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function confirm($token) {
        /**
         * @var Mail $mail
         */
        $mail = $this->mailRepo->findOneByConfirmUUID($token);
        if (null === $mail) {
            return false;
        }

        $mail->setConfirmUUID(null);
        $now = new \DateTime();
        $mail->setConfirmed($now);
        $this->em->flush();
        return true;
    }

    /**
     * @param string $mail
     * @return bool
     * @throws NoMailException
     */
    public function unsubscribe($mail) {
        /**
         * @var Mail $obj
         */
        $obj = $this->mailRepo->findOneByMail($mail);
        if (null === $obj) {
            throw new NoMailException();
        }

        if (null === $obj->getConfirmed()) {
            throw new NoMailException();
        }

        $uuid = Uuid::uuid4();
        $now = new \DateTime();

        $obj->setUnsubscribeUUID($uuid->toString());
        $obj->setUnsubscribedRequested($now);

        $this->em->flush();

        $settings = $this->ci->get('settings');

        $unsubscribeMail = new UnsubscribeMail($obj, $settings, $this->ci->get('mailView'));

        $unsubscribeMail->send();
        return true;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function unsubscribeConfirm($token) {
        /**
         * @var Mail $mail
         */
        $mail = $this->mailRepo->findOneByUnsubscribeUUID($token);
        if (null === $mail) {
            return false;
        }

        $yesterday = new \DateTime();
        $yesterday->modify('-1 day');

        if ($yesterday > $mail->getUnsubscribedRequested()) {
            return false;
        }

        $this->em->remove($mail);
        $this->em->flush();
        return true;
    }

    public function getAll() {
        return $this->mailRepo->findAll();
    }

    /**
     * @return null
     */
    public function sendNewsletters() {
        /**
         * @var BerichtRepo $berichtRepo
         */
        $berichtRepo = $this->em->getRepository('App\Entity\Bericht');

        /**
         * @var Mail[] $mails
         */
        $mails     = $this->mailRepo->getOutdatedMails();

        $now = new \DateTime();
        $twoWeeksFromNow = new \DateTime();
        $twoWeeksFromNow->modify('+2 weeks');

        /**
         * @var Bericht[] $berichten
         */
        $berichten = $berichtRepo->getByDate($now, true);
        /**
         * @var Bericht[] $berichtentoSort
         */
        $berichtentoSort = $berichtRepo->getPublishedInFuture();

        $sortedByDate = [];

        foreach ($berichtentoSort as $bericht) {
            if (!isset($sortedByDate[$bericht->getStartDate()->format('Ymd')])) {
                $sortedByDate[$bericht->getStartDate()->format('Ymd')] = [];
            }
            $sortedByDate[$bericht->getStartDate()->format('Ymd')][] = $bericht;
        }

        ksort($sortedByDate);

        $settings = $this->ci->get('settings');
        $now = new \DateTime();

        //die(var_dump($sortedByDate));

        foreach ($mails as $mail) {
            $date = new \DateTime();
            echo $date->format('H:i:s d-m-Y') . " - Mailing: " . $mail->getMail() . "\n";
            $newsletter = new NewsletterMail($mail, $this->ci->get('mailView'), $berichten, $sortedByDate, $settings);
            $newsletter->send();
            $mail->setLastCorrespondence($now);
        }
        $this->em->flush();
    }
}