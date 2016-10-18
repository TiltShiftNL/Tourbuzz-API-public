<?php

namespace App\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use App\Entity\Bericht;

class BerichtRepo extends EntityRepository
{
    public function getByDate(\DateTime $date, $isLive=null) {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEntityManager();

        $liveQuery = null === $isLive ? '' : 'AND b.isLive = :isLive';

        $query = $em->createQuery('
            SELECT
                b
            FROM
               App\Entity\Bericht b
            WHERE
                b.startDate <= :qdate
                AND b.endDate >= :qdate
                ' . $liveQuery . '
            ORDER BY b.important DESC, b.startDate ASC'
        );

        $query->setParameter('qdate', $date->format('Y-m-d'));
        if (null !== $isLive) {
            $query->setParameter('isLive', $isLive);
        }

        return $query->getResult();
    }

    public function getPublishedInFuture() {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEntityManager();

        $now = new \DateTime();

        $query = $em->createQuery('
            SELECT
                b
            FROM
               App\Entity\Bericht b
            WHERE
                b.startDate > :qdate
                AND b.isLive = true'
        );

        $query->setParameter('qdate', $now->format('Y-m-d'));

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
            ORDER BY b.startDate DESC, b.startDate ASC'
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
            ORDER BY b.important DESC, b.startDate ASC'
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