<?php

namespace TV\FindyourbandBundle\Repository;

class ProvinceRepository extends \Doctrine\ORM\EntityRepository
{
    public function getProvinces()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
