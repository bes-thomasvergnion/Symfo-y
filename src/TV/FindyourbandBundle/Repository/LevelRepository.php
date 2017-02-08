<?php

namespace TV\FindyourbandBundle\Repository;

class LevelRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLevels()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
