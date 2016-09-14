<?php

namespace App\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class MailRepo extends EntityRepository
{
    public function getOutdatedMails() {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT
                m
            FROM
               App\Entity\Mail m
            WHERE
                m.lastCorrespondence <= :twoWeeks
                OR m.lastCorrespondence IS NULL
                AND m.confirmed IS NOT NULL
        ');

        $date = new \DateTime();
        $date->modify('-2 weeks');
        $query->setParameter('twoWeeks', $date->format('Y-m-d'));

        return $query->getResult();
    }
}