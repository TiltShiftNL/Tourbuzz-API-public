<?php

namespace App\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use App\Entity\Bericht;

class BerichtRepo extends EntityRepository
{
    public function getByDate($date) {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT
                b
            FROM
               App\Entity\Bericht b
            WHERE
                b.startDate <= :qdate
                AND b.endDate >= :qdate
            ORDER BY b.important DESC, b.endDate DESC'
        );

        $query->setParameter('qdate', $date->format('Y-m-d'));

        return $query->getResult();
    }

    public function getByDateRange(\DateTime $startDate, \DateTime $endDate) {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT
                b
            FROM
               App\Entity\Bericht b
            WHERE
                    b.endDate >= :startDate
                AND b.startDate <= :endDate
            ORDER BY b.startDate DESC, b.endDate DESC'
        );

        $query->setParameter('startDate', $startDate->format('Y-m-d'));
        $query->setParameter('endDate', $endDate->format('Y-m-d'));

        return $query->getResult();
    }

    public function getSortedAll() {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT
                b
            FROM
               App\Entity\Bericht b
            ORDER BY b.important DESC, b.endDate DESC'
        );

        return $query->getResult();
    }

    public function getSMSQueue() {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT
                b
            FROM
               App\Entity\Bericht b
            WHERE b.sms_send IS NULL'
        );

        return $query->getResult();
    }
}