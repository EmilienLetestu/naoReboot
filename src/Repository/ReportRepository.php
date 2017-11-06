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
     * @param $order
     * @param $sort
     * @param $limit
     */
    public function whereValidated(QueryBuilder $queryBuilder, $validated, $order, $sort, $limit)
    {
        $queryBuilder
            ->andWhere("r.validated = {$validated}")
            ->orderBy("r.{$sort}","{$order}")
            ->setMaxResults($limit)
        ;
    }

    /**
     * fetch all unvalidated report posted 30 days ago or more
     * @return array
     */
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
     * fetch validated or unvalidated report based on user access level
     * @param $birdId
     * @param $validated
     * @param $order
     * @param $sort
     * @param $limit
     * @return array
     */
    public function findAllDependOnViewer($birdId,$validated,$order,$sort,$limit)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this->whereReportedBird($queryBuilder,$birdId);
        $this->whereValidated($queryBuilder,$validated,$order,$sort,$limit);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;

    }

    /**
     * fetch the last 9 published and validated to display on home
     * @return array
     */
    public function findAllForHomePage()
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this->whereValidated($queryBuilder,1,'Desc','addedOn',9);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**fetch the last report published for a given user
     * @param $userId
     * @return array
     */
    public function findUserLastPublication($userId)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this->whereReporter($queryBuilder,$userId);
        $this->whereValidated($queryBuilder,1,'Desc','addedOn',1);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }
}