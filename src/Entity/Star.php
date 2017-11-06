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
 * @ORM\Entity
 * @ORM\Table(name="star")
 * @ORM\Entity(repositoryClass="App\Repository\StarRepository")
 */
class Star
{
    /**
     * @var
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Report", inversedBy="stars")
     * @ORM\JoinColumn(name="report_id", referencedColumnName="id")
     * id from starred report
     */
    private $report;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="stars")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
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
