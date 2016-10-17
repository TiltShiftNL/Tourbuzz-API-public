<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class TokenRepo extends EntityRepository
{
    public function getExpiredTokens(\DateTime $expiredBefore) {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT
                t
            FROM
               App\Entity\Token t
            WHERE
              t.lastAction < :expiredBefore'
        );

        $query->setParameter('expiredBefore', $expiredBefore->format('Y-m-d H:i:s'));

        return $query->getResult();
    }
}