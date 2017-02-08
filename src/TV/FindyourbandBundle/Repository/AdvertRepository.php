<?php

namespace TV\FindyourbandBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdvertRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAdverts($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->getQuery()
        ;
        
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getAdvertsHome()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getAdvertsAdmin()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getAdvertsWithFilters(\TV\FindyourbandBundle\Entity\Search $search, $page, $nbPerPage)
    {            
        $query = $this->createQueryBuilder('g');
        $andX = $query->expr()->andX();

        if(null !== $search->getProvince()){
            $andX->add('g.province = :province');
            $query->setParameter('province', $search->getProvince());
        }
        if(null !== $search->getGenre()){
            $andX->add('g.genre = :genre');
            $query->setParameter('genre', $search->getGenre());
        }
        if(null !== $search->getLevel()){
            $andX->add('g.level = :level');
            $query->setParameter('level', $search->getLevel());
        }
        if(null !== $search->getInstrument()){
            $andX->add('g.instrument = :instrument');
            $query->setParameter('instrument', $search->getInstrument());
        }

        if(!empty($search->getInstrument()) || !empty($search->getLevel()) || !empty($search->getGenre()) || !empty($search->getProvince())){
            $query->where($andX);
        }
        $query->orderBy('g.date', 'DESC');
        
        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }

    public function myFindOne($id)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
          ->where('a.id = :id')
          ->setParameter('id', $id)
        ;

        return $qb
          ->getQuery()
          ->getResult()
        ;
    }
}
