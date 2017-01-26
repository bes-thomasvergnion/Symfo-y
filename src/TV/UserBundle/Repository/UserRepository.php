<?php

namespace TV\UserBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
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
    
    public function getUsersWithFilters(\TV\FindyourbandBundle\Entity\Search $search)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.enabled = true')
            ->where('a.province = :province')
            ->setParameter('province', $search->getProvince())
            ->andWhere('a.genre = :genre')
            ->setParameter('genre', $search->getGenre())
            ->andWhere('a.level = :level')
            ->setParameter('level', $search->getLevel())
            ->orderBy('a.id', 'DESC')
            ->getQuery()
        ;

        return $query->getResult();
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
//        $qb = $this->createQueryBuilder('a');
//
//        // On fait une jointure avec l'entité Category avec pour alias « c »
//        $qb
//          ->innerJoin('a.invitations', 'c')
//          ->addSelect('c')
//        ;
//
//        // Puis on filtre sur le nom des catégories à l'aide d'un IN
//        $qb->where($qb->expr()->in('c.sender', $user));
//        // La syntaxe du IN et d'autres expressions se trouve dans la documentation Doctrine
//
//        // Enfin, on retourne le résultat
//        return $qb
//          ->getQuery()
//          ->getResult()
//        ;
    }
}

