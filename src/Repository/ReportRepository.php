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
     * @param $id
     * @return mixed
     */
    public function findReport($id)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $queryBuilder
            ->where('r.id = :id')
            ->setParameter('id',$id)
        ;

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
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
            ->where('r.validated = :state')
            ->setParameter('state', 0)
            ->andWhere('r.addedOn <= :date')
            ->setParameter('date', new \DateTime($date));

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * fetch validated or unvalidated
     * @param $validated
     * @return array
     */
    public function findAllReport($validated)
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder
            ->andWhere('r.validated = :validated')
            ->setParameter('validated', $validated)
        ;

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $validated
     * @param $order
     * @param $sort
     * @param null $limit
     * @return array
     */
    public function findSelection($validated,$order,$sort,$limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this->whereValidated($queryBuilder,$validated,$order,$sort,$limit);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $validated
     * @return QueryBuilder
     */
    public function findSpeciesForForm($validated)
    {
       return $this
                ->createQueryBuilder('r')
                ->andWhere('r.validated = :validated')
                ->setParameter('validated', $validated)
       ;
    }

    /**
     * @param $validated
     * @param $order
     * @param $sort
     * @param null $limit
     * @param $birdId
     * @return array
     */
    public function findSelectionWithBird($validated,$order,$sort,$limit=null,$birdId)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this->whereValidated($queryBuilder,$validated,$order,$sort,$limit);
        $this->whereReportedBird($queryBuilder, $birdId);

        return $queryBuilder
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $id
     * @return array
     */
    public function findAllWithBirdName($id)
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder
            ->innerJoin('r.bird','b')
            ->addSelect('b')

        ;
        $queryBuilder
            ->where($queryBuilder->expr()->in('b.id',$id))
            ->andWhere('r.validated = 1');

        return $queryBuilder
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $birdId
     * @return array
     */
    public function findLastReportWithBird($birdId)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this-> whereValidated($queryBuilder,1,'ASC','addedOn',1);
        $this->whereReportedBird($queryBuilder,$birdId);

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * fetch the last 6 published and validated to display on home
     * @return array
     */
    public function findAllForHomePage()
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $this->whereValidated($queryBuilder,1,'DESC','addedOn',6);

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
            ->getOneOrNullResult()
        ;
    }

    /**
     * Will return all superior or equal to a given access level
     * Use to cover access level 2 and 3 on buildStatistics()
     * @param $accessLevel
     * @return array
     */
    public function countWithUserAccessLevel($accessLevel)
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder
            ->innerJoin('r.user', 'u', 'WITH', 'u.accessLevel >= :accessLevel')
            ->setParameter('accessLevel',$accessLevel);

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     * @return array
     */
    public function countWithLowerAccessLevel()
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder
            ->innerJoin('r.user', 'u', 'WITH', 'u.accessLevel = 1');

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     * @return array
     */
    public function countAllValidated()
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder
            ->andWhere('r.validated = 1')
        ;

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     * @param $year
     * @param $month
     * @return array
     */
    public function countValidatedThisMonth($year,$month)
    {
        $date = new \DateTime($year.'-'.$month.'-01');

        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder
            ->andWhere('r.addedOn BETWEEN :start AND :end')
            ->setParameter('start', $date->format('Y-m-d'))
            ->setParameter('end', $date->format('Y-m-t'))
        ;

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     * @param $year
     * @return array
     */
    public function countValidatedThisYear($year)
    {
        $dateStart = new \DateTime($year.'-01-01');
        $dateEnd   = new \DateTime($year.'-12-31');

        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder
            ->andWhere('r.addedOn BETWEEN :start AND :end')
            ->setParameter('start', $dateStart->format('Y-m-d'))
            ->setParameter('end', $dateEnd->format('Y-m-t'))
        ;

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

}

