<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 23/09/17
 * Time: 21:26
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="user")
 *
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\column(type="string", length =30)
     */
    private $name;

    /**
     * @ORM\column(type="string", length =30)
     */
    private $surname;

    /**
     * @var
     * @ORM\column(type="string", length=255)
     */
    private $email;

    /**
     * @var
     * @ORM\column(type="date")
     */
    private $createdOn;

    /**
     * @var
     * @ORM\column(type="smallint")
     */
    private $accessLevel;

    /**
     * @var
     * @ORM\column(type="string")
     */
    private $pswd;

    /**
     * @var
     * @ORM\column(type="boolean")
     */
    private $activated;

    /**
     * @var
     * @ORM\column(type="boolean")
     */
    private $onHold;

    /**
     * @var
     * @ORM\column(type="string", length=40)
     */
    private $confirmationToken;

    /**
     * @var
     * @ORM\column(type="boolean")
     */
    private $ban;

    /**
     * @var
     * @ORM\column(type="boolean")
     */
    private $deactivated;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Report", mappedBy="user")
     */
    private $reports;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Validation", mappedBy="user")
     */
    private $validations;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Star", mappedBy="user")
     */
    private $stars;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="user")
     */
    private $notifications;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name) :User
    {
        $this->name = ucfirst(strip_tags(mb_strtolower($name)));

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return User
     */
    public function setSurname(string $surname) :User
    {
        $this->surname = ucfirst(strip_tags(mb_strtolower($surname)));

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email) :User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param  $createdOn
     * @return User
     */
    public function setCreatedOn($createdOn) :User
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * @param int $accessLevel
     * @return User
     */
    public function setAccessLevel($accessLevel) :User
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPswd()
    {
        return $this->pswd;
    }

    /**
     * @param string $pswd
     * @return User
     */
    public function setPswd(string $pswd) :User
    {
        $this->pswd = password_hash($pswd, PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * @param bool $activated
     * @return User
     */
    public function setActivated(bool $activated) :User
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOnHold()
    {
        return $this->onHold;
    }

    /**
     * @param bool $onHold
     * @return User
     */
    public function setOnHold(bool $onHold) :User
    {
        $this->onHold = $onHold;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param int $length
     * @return User
     */
    public function setConfirmationToken(int $length) :User
    {

        $confirmationToken = $this->generateConfirmationToken($length);
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBan()
    {
        return $this->ban;
    }

    /**
     * @param bool $ban
     * @return User
     */
    public function setBan(bool $ban) :User
    {
        $this->ban = $ban;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeactivated()
    {
        return $this->deactivated;
    }

    /**
     * @param bool $deactivated
     * @return User
     */
    public function setDeactivated(bool $deactivated) :User
    {
        $this->deactivated = $deactivated;

        return $this;
    }

    /**
     * User constructor
     */
    public function __construct()
    {
        $this->reports       = new ArrayCollection();
        $this->validations   = new ArrayCollection();
        $this->stars         = new ArrayCollection();
        $this->notifications = new ArrayCollection();

    }

    /**
     * @param Report $report
     * @return $this
     */
    public function addReport(Report $report)
    {
        $this->reports[] = $report;

        $report->setReport($this);

        return $this;
    }

    /**
     * @param Report $report
     */
    public function removeReport(Report $report)
    {
        $this->reports->removeElement($report);
    }

    /**
     * @return ArrayCollection
     */
    public function getReports()
    {
        return $this->reports;
    }

    /**
     * @param Validation $validation
     * @return $this
     */
    public function addValidation(Validation $validation)
    {
        $this->validations[] = $validation;

        $this->setValidation($this);

        return $this;
    }

    /**
     * @param Validation $validation
     */
    public function removeValidation(Validation $validation)
    {
        $this->validations->removeElement($validation);
    }


    /**
     * @return ArrayCollection
     */
    public function getValidations()
    {
        return $this->validations;
    }

    /**
     * @param Star $star
     * @return mixed
     */
    public function addStar(Star $star)
    {
        $this->stars[] = $star;

        $this->setStar($this);

        return $this;
    }

    /**
     * @param Star $star
     */
    public function removeStar(Star $star)
    {
        $this->stars->removeElement($star);
    }

    /**
     * @return ArrayCollection
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * @param Notification $notification
     * @return $this
     */
    public function addNotification(Notification $notification)
    {
        $this->notifications[] = $notification;

        $this->setNotification($this);

        return $this;
    }

    /**
     * @param Notification $notification
     */
    public function removeNotification(Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * @return ArrayCollection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }


    /**
     * @param int $length
     * @return string
     */
    private function generateConfirmationToken(int $length) :string
    {
        $strToRandom = ('abcdefghijklmnoptqrdtuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        return substr(str_shuffle(str_repeat($strToRandom, $length)), 0, $length);
    }

}

