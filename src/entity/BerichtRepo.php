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
                AND b.endDate > :qdate
            ORDER BY b.endDate DESC'
        );

        $query->setParameter('qdate', $date->format('Y-m-d'));

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
            ORDER BY b.endDate DESC'
        );

        return $query->getResult();
    }
}