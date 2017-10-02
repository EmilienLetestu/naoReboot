<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 02/09/17
 * Time: 10:41
 */

namespace App\Entity;

Use Doctrine\ORM\Mapping as ORM;

/**
 * Class Notification
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    private $user;

    /**
     * @var
     * @ORM\Column(type="smallint")
     * notification array index value
     */
    private $type;

    /**
     * @var
     * @ORM\Column(type="boolean")
     * if you user hasn't seen it yet value = 0
     * if user saw it value = 1
     */
    private $seen;

    /**
     * @var
     * @ORM\Column(type="date")
     */
    private $notifiedOn;


    /**----------------setters and getters-----------*/


    public function getId()
    {
        return $this->id;
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

    /**
     * @return mixed
     */
    public function getType()
    {
       return $this->type;
    }

    /**
     * @param int $type
     * @return Notification
     */
    public function setType(int $type) :Notification
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param bool $seen
     * @return Notification
     */
    public function setSeen(bool $seen) :Notification
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifiedOn()
    {
        return $this->notifiedOn;
    }

    /**
     * @param $notifiedOn
     * @return Notification
     */
    public function setNotifiedOn($notifiedOn) :Notification
    {
        $this->notifiedOn = $notifiedOn;

        return $this;
    }

}

