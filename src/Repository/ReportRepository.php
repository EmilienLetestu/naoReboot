<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 11/09/17
 * Time: 10:50
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


class ReportRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param $birdId
     */
    public function whereReportedBird(QueryBuilder $queryBuilder, $birdId)
    {
        $queryBuilder
            ->andWhere('r.bird = :id')
            ->setParameter('id',$birdId)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $userId
     */
    public function whereReporter(QueryBuilder $queryBuilder, $userId)
    {
        $queryBuilder
            ->andWhere('r.user = :id')
            ->setParameter('id',$userId)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $validated
     * @param $orderBy
     * @param $sort
     * @param $limit
     */
    public function whereValidated(QueryBuilder $queryBuilder, $validated, $orderBy, $sort, $limit)
    {
        $queryBuilder
            ->andWhere("r.validated = {$validated}")
            ->orderBy("r.{$orderBy}","{$sort}")
            ->setMaxResults($limit)
        ;
    }

    public function findAllExpired()
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $date = date('Y-m-d', strtotime("-30 days"));

        $queryBuilder
            ->where("r.validated = :state")
            ->setParameter("state", 0)
            ->andWhere("r.addedOn <= :date")
            ->setParameter("date", new \DateTime($date));

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $birdId
     * @param $validated
     * @param $orderBy
     * @param $sort
     * @param $limit
     * @return array
     */
    public function findAllBirdDependOnViewer($birdId,$validated,$orderBy,$sort,$limit)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this->whereReportedBird($queryBuilder,$birdId);
        $this->whereValidated($queryBuilder,$validated,$orderBy,$sort,$limit);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;

    }

    /**
     * @return array
     */
    public function findAllForHomePage()
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this->whereValidated($queryBuilder,1,'addedOn','Desc',9);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }
}