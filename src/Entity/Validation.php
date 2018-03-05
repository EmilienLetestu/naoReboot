<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 02/09/17
 * Time: 10:05
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Validation
 * @package App\Entity
 */
class Validation
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     * Id from validated report
     */
    private $report;

    /**
     * Id from user whom was adding validation point
     */
    private $user;


    /**---------------------- setters & getters ------------------------*/


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * @param Report $report
     * @return Validation
     */
    public function setReport(Report $report) :Validation
    {
        $this->report = $report;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}
