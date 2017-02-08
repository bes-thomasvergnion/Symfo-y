<?php

namespace TV\UserBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function find($id){
        $query = $this->createQueryBuilder('u')
            ->where('u.id= :id')
                ->setParameter('id', $id)
                ->leftJoin('u.bands', 'b')
                ->addSelect('b');
        return $query->getQuery()->getOneOrNullResult();
    }
    
    public function getUsers($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getActivedUsers($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.enabled = true')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
          ;
        return new Paginator($query, true);
    }
    
    public function getUsersHome()
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.enabled = true')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getUsersAdmin()
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
        ;

        return $query->getResult();
    }
    
    public function getUsersWithFilters(\TV\FindyourbandBundle\Entity\Search $search, $page, $nbPerPage)
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
        $query->orderBy('g.id', 'DESC');
        
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
    
    public function getUserInvitations()
    {
        $query = $this->createQueryBuilder('a')        
            ->getQuery()
        ;

        return $query->getResult();
    }
}

