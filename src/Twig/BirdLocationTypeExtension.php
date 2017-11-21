<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 21/11/2017
 * Time: 16:03
 */

namespace App\Twig;


use App\Entity\Report;
use Doctrine\ORM\EntityManager;

class BirdLocationTypeExtension extends \Twig_Extension
{
    private $doctrine;

    public function __construct(
        EntityManager $doctrine
    )
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('birdLocation',[$this,'birdLocationFilter'])
        ];
    }

    public function birdLocationFilter($birdId)
    {
        $repository = $this->doctrine->getRepository(Report::class);

       return $repository->findByBird($birdId);
    }
}
