<?php

namespace TV\FindyourbandBundle\Repository;

class InstrumentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getInstruments()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
