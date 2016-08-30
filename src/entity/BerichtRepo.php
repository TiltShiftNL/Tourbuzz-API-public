<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class BerichtRepo extends EntityRepository
{
    public function getCurrent() {
        $connection = $this->getEntityManager()->getConnection();

        $today = new \DateTime();

        return $connection->fetchAll("
    SELECT
		*
	FROM
		berichten
	WHERE
		startdate <= :today
		AND enddate > :today
	ORDER BY enddate DESC",
            [
                'today' => $today->format('Y-m-d')
            ]);
    }
}