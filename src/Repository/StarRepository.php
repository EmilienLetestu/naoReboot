<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 15/09/17
 * Time: 08:03
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class StarRepository extends EntityRepository
{
    /**
     * join tables and select all the "stars" gathered by a given report
     * @param $id
     * @return array
     */
    public function findStaredReportBy($id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->innerJoin('s.report','r')
            ->addSelect('r')
        ;

        $queryBuilder->where($queryBuilder->expr()->in('r.id',$id));

        return(
            $queryBuilder->getQuery()->getResult()
        );
    }

    /**
     * join tables and select all the "stars' added by a given user
     * @param $id
     * @return array
     */
    public function findStarAddedBy($id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->innerJoin('s.user','u')
            ->addSelect('u')
        ;

        $queryBuilder->where($queryBuilder->expr()->in('u.id',$id));

        return(
        $queryBuilder->getQuery()->getResult()
        );
    }
}

