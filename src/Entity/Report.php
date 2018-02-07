<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 01/09/17
 * Time: 08:27
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Report
 * @package App\Entity
 */
class Report
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $bird;

    /**
     * @var
     */
    private $user;

    /**
     * @var
     */
    private $starNbr;

    /**
     * @var
     */
    private $location;

    /**
     * @var
     */
    private $satNav;

    /**
     * @var
     */
    private $addedOn;

    /**
     * @var
     */
    private $nbrOfBirds;

    /**
     * @var
     */
    private $comment = null;

    /**
     * @var null
     */
    private $pictRef = null;

    /**
     * @var
     */
    private $validated;

    /**
     * @var
     */
    private $validationScore;

    /**
     * @var
     */
    private $validations;

    /**
     * @var
     */
    private $stars;

    /**---------------------- setters & getters ------------------------*/


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Bird $bird
     * @return $this
     */
    public function setBird(Bird $bird)
    {
        $this->bird = $bird;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBird()
    {
        return $this->bird;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
       $this->user = $user;
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
     * @param int $starNbr
     * @return Report
     */
    public function setStarNbr(int $starNbr) :Report
    {
        $this->starNbr = $starNbr;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStarNbr()
    {
        return $this->starNbr;
    }

    /**
     * @param string $location
     * @return Report
     */
    public function setLocation(string $location) :Report
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $satNav
     * @return Report
     */
    public function setSatNav(string $satNav) :Report
    {
        $this->satNav = $satNav;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSatNav()
    {
        return $this->satNav;
    }

    /**
     * @param  $addedOn
     * @return Report
     */
    public function setAddedOn($addedOn) :Report
    {
        $this->addedOn = $addedOn;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddedOn()
    {
        return $this->addedOn;
    }

    /**
     * @param int $nbrOfBirds
     * @return Report
     */
    public function setNbrOfBirds(int $nbrOfBirds) :Report
    {
        $this->nbrOfBirds = $nbrOfBirds;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbrOfBirds()
    {
        return $this->nbrOfBirds;
    }


    /**
     * @param string $comment
     * @return Report
     */
    public function setComment(string $comment) :Report
    {
        $this->comment = ucfirst(strip_tags($comment));

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }


    /**
     * @param string $pictRef
     * @return Report
     */
    public function setPictRef(string $pictRef) :Report
    {
        $this->pictRef = $pictRef;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPictRef()
    {
        return $this->pictRef;
    }

    /**
     * @param bool $validated
     * @return Report
     */
    public function setValidated(bool $validated) :Report
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * @param int $validationScore
     * @return Report
     */
    public function setValidationScore(int $validationScore) :Report
    {
        $this->validationScore = $validationScore;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidationScore()
    {
        return $this->validationScore;
    }

    /**
     * Report constructor.
     */
    public function __construct()
    {
        $this->validations = new ArrayCollection();
        $this->stars       = new ArrayCollection();
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
     * @return $this
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
}

