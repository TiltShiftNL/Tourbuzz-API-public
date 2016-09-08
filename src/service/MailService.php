<?php

namespace App\Service;

use App\Entity\Mail;
use App\Entity\MailRepo;
use App\Exception\MailExistsException;
use App\View\Mail\RegisterMail;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

class MailService {


    /**
     * @var \Interop\Container\ContainerInterface
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
     * @param \Interop\Container\ContainerInterface $ci
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
    public function register($mail, $language, $name) {
        $object = $this->mailRepo->findOneByMail($mail);
        if (null !== $object) {
            throw new MailExistsException();
        }

        $uuid = Uuid::uuid4();
        $now = new \DateTime();

        $obj = new Mail();
        $obj->setMail($mail);
        $obj->setName($name);
        $obj->setLanguage($language);
        $obj->setConfirmUUID($uuid->toString());
        $obj->setCreated($now);

        $this->em->persist($obj);
        $this->em->flush();

        $settings = $this->ci->get('settings');

        $registerMail = new RegisterMail($obj, $settings);

        $registerMail->send();
        return true;
    }
}