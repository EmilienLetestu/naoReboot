<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 15/09/17
 * Time: 08:21
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class ValidationRepository extends EntityRepository
{
    /**
     * join tables and select all validation gathered by a given report
     * @param $id
     * @return array
     */
    public function findValidatedReportBy($id)
    {
        $queryBuilder = $this->createQueryBuilder('v');
        $queryBuilder
            ->innerJoin('v.report','r')
            ->addSelect('r')
        ;

        $queryBuilder->where($queryBuilder->expr()->in('r.id',$id));

        return(
            $queryBuilder->getQuery()->getResult()
        );

    }

    /**
     * join tables and select all validation added by a given user
     * @param $id
     * @return array
     */
    public function findValidationAddedBy($id)
    {
        $queryBuilder = $this->createQueryBuilder('v');
        $queryBuilder
            ->innerJoin('v.user','u')
            ->addSelect('u')
        ;

        $queryBuilder->where($queryBuilder->expr()->in('u.id',$id));

        return(
            $queryBuilder->getQuery()->getResult()
        );
    }
}

