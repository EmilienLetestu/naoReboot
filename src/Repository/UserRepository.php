<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 13/09/17
 * Time: 13:44
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class UserRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param $email
     */
    public function whereEmail(QueryBuilder $queryBuilder, $email)
    {
        $queryBuilder
            ->andWhere('u.email = :email')
            ->setParameter('email',$email)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $pswd
     */
    public function wherePswd(QueryBuilder $queryBuilder, $pswd)
    {
        $queryBuilder
            ->andWhere('u.pswd = :pswd')
            ->setParameter('pswd',$pswd)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $activated
     */
    public function whereActivated(QueryBuilder $queryBuilder, $activated)
    {
        $queryBuilder
            ->andWhere('u.activated = :activated')
            ->setParameter('activated',$activated)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $accessLevel
     */
    public function whereAccessLevel(QueryBuilder $queryBuilder, $accessLevel)
    {
        $queryBuilder
            ->andWhere('u.accessLevel = :accessLevel')
            ->setParameter('accessLevel',$accessLevel)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $userId
     */
    public function whereId(QueryBuilder $queryBuilder, $userId)
    {
        $queryBuilder
            ->andWhere('u.id = :userId')
            ->setParameter('userId',$userId)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $deactivated
     */
    public function whereDeactivated(QueryBuilder $queryBuilder, $deactivated)
    {
        $queryBuilder
            ->andWhere('u.deactivated = :deactivated')
            ->setParameter('deactivated',$deactivated)
        ;
    }

    /***
     * @param QueryBuilder $queryBuilder
     * @param $onHold
     */
    public function whereOnHold(QueryBuilder $queryBuilder, $onHold)
    {
        $queryBuilder
            ->andWhere('u.onHold = :onHold')
            ->setParameter('onHold',$onHold)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $ban
     */
    public function whereBan(QueryBuilder $queryBuilder, $ban)
    {
        $queryBuilder
            ->andWhere('u.ban = :ban')
            ->setParameter('ban',$ban)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $dateToGet
     */
    public function whereCreatedOn(QueryBuilder $queryBuilder,$dateToGet)
    {
        $date = date('Y-m-d', strtotime($dateToGet));

        $queryBuilder
            ->andWhere("u.createdOn <= :date")
            ->setParameter("date", new \DateTime($date))
        ;
    }

    /**
     * fetch all unactivated accounts created 30 days ago or more
     * @param $accessLevel
     * @return array
     */
    public function findDeletableAccount($accessLevel,$nMonthAgo)
    {
        $queryBuilder = $this->createQueryBuilder('u');

       $this->whereActivated($queryBuilder, 0);
       $this->whereAccessLevel($queryBuilder,$accessLevel);
       $this->whereCreatedOn($queryBuilder,$nMonthAgo);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * find matching user for a given email address
     * @param $email
     * @return array
     */
    public function findLogin($email)
    {
        $queryBuilder = $this->createQueryBuilder('u');

        $this->whereEmail($queryBuilder,$email);
        $this->whereBan($queryBuilder,0);
        $this->whereDeactivated($queryBuilder,0);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array
     */
    public function countAllActivated()
    {
        $queryBuilder = $this->createQueryBuilder('u');

        $this->whereActivated($queryBuilder,1);

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     * Will return for a given access level the number of activated account
     * @param $accessLevel
     * @return array
     */
    public function countAllWithAccessLevel($accessLevel)
    {
        $queryBuilder = $this->createQueryBuilder('u');

        $this->whereActivated($queryBuilder,1);
        $this->whereAccessLevel($queryBuilder,$accessLevel);

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     * Will return all user with an activated account
     * @return array
     */
    public function findAllActivated()
    {
       $queryBuilder = $this->createQueryBuilder('u');

       $this->whereActivated($queryBuilder,1);

       return $queryBuilder
           ->getQuery()
           ->getResult()
       ;
    }

}

