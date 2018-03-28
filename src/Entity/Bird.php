<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 04/09/17
 * Time: 10:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class Bird
 * @package App\Entity
 */
class Bird
{

    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $speciesLatin;

    /**
     * @var
     */
    private $synonymous;

    /**
     * @var
     */
    private $speciesFr;

    /**
     * @var
     */
    private $breed;

    /**
     * @var
     */
    private $birdGroup;

    /**
     * @var
     */
    private $reports;


    /**---------------------- setters & getters ------------------------*/


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    public function getSpeciesLatin()
    {
        return $this->speciesLatin;
    }

    /**
     * @param string $speciesLatin
     * @return Bird
     */
    public function setSpeciesLatin(string $speciesLatin) :Bird
    {
        $this->speciesLatin = $speciesLatin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSynonymous()
    {
        return $this->synonymous;
    }

    /**
     * @param string $synonymous
     * @return Bird
     */
    public function setSynonymous(string $synonymous) :Bird
    {
        $this->synonymous = $synonymous;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpeciesFr()
    {
        return $this->speciesFr == '' ?
            $this->getSpeciesNameOnly() :
            $this->speciesFr
        ;
    }

    /**
     * @param string $speciesFr
     * @return Bird
     */
    public function setSpeciesFr(string $speciesFr) :Bird
    {
        $this->speciesFr = $speciesFr;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * @param string $breed
     * @return $this
     */
    public function setBreed(string $breed)
    {
        $this->breed = $breed;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirdGroup()
    {
        return $this->birdGroup;
    }

    /**
     * @param string $birdGroup
     * @return $this
     */
    public function setBirdGroup(string $birdGroup)
    {
        $this->birdGroup = $birdGroup;

        return $this;
    }

    /**
     * Bird constructor.
     */
    public function __construct()
    {
        $this->reports = new ArrayCollection();
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
     * @return mixed
     */
    public function getReports()
    {
        return $this->reports;
    }

    /**
     * Use to fill entity type form
     * @return mixed
     */
    public function getSpeciesNameOnly()
    {
        $speciesLatin = $this->getSpeciesLatin();

        $sanitize = preg_replace('/\(|\)/','',$speciesLatin);
        $extractSpecies = preg_split('/(?=[A-Z])/',$sanitize);

        return $extractSpecies[1];
    }

    /**
     * Use to fill entity type form
     * @return string
     */
    public function getSpeciesForForm()
    {
        $fr = trim($this->getSpeciesFr());
        $splitFr = preg_split('/;|,/',$fr);
        $sanitizeFr = preg_split('/\(|\)/',$splitFr[0]);


        return $this->getSpeciesNameOnly().' -- '.$sanitizeFr[0];
    }

}

