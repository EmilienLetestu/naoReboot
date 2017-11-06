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
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @ORM\column(type="boolean", options={"default"=false})
     */
    private $activated = false;

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
     * @ORM\column(type="boolean", options={"default"=false})
     */
    private $ban = false;

    /**
     * @var
     * @ORM\column(type="boolean", options={"default"=false})
     */
    private $deactivated = false;

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
     * @param $format
     * @return User
     */
    public function setCreatedOn($format) :User
    {
        $this->createdOn = new \DateTime(date($format));

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

    /**---------------------- entity relation management------------------------*/

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

    /**---------------------- advanceUserInterface methods------------------------*/

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->getPswd();
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $accessLevel = $this->getAccessLevel();

        $role = [1 => 'USER',
                 2 => 'VALIDATOR',
                 3 => 'ADMIN'];

        return array("ROLE_{$role[$accessLevel]}");
    }

    /**
     * default method from advanceUserInterface,
     * must be declare even blank
     */
    public function eraseCredentials()
    {

    }

    /**
     * return null as pswd use bcrypt algorithm
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function isAccountNonLocked()
    {
        $locked = ($this->getBan() || $this->getDeactivated()) ? false : true;

        return $locked;
    }

    /**
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->getActivated();
    }

    /**
     * @return string
     */
    public function serialize()
    {
       return serialize([
           $this->getId(),
           $this->getName(),
           $this->getSurname(),
           $this->getEmail(),
           $this->getActivated()
       ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->name,
            $this->surname,
            $this->email,
            $this->activated
            ) = unserialize($serialized)
        ;
    }


}

