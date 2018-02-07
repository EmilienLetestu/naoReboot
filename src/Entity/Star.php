<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 01/09/17
 * Time: 09:14
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Star
 * @package App\Entity
 */
class Star
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     * id from starred report
     */
    private $report;

    /**
     * @var
     * id from user whom was adding star
     */
    private $user;


    /**------------------setters and getters----------------*/


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
     * @return $this
     */
    public function setReport(Report $report)
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
