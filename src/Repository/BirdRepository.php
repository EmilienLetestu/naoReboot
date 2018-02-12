<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 30/11/2017
 * Time: 10:04
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class BirdRepository extends EntityRepository
{
    public function findBirdLike($search)
    {
        $queryBuilder = $this->createQueryBuilder('b');
        $queryBuilder
            ->andWhere('b.id LIKE :search
                OR b.speciesFr LIKE :search
                or b.speciesLatin LIKE :search
                OR b.breed LIKE :search
                OR b.birdGroup LIKE :search')
            ->innerJoin('b.reports', 'r')
            ->andWhere('r.validated = 1')
            ->addSelect('r')
            ->setParameter('search', '%'.$search.'%')
        ;

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }
}

