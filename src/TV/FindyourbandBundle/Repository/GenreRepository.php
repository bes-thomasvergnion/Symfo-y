<?php

namespace TV\FindyourbandBundle\Repository;

class GenreRepository extends \Doctrine\ORM\EntityRepository
{
    public function getGenres()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
