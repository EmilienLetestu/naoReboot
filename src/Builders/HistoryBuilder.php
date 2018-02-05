<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 30/11/2017
 * Time: 15:31
 */

namespace App\Builders;

use App\Entity\Report;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class HistoryBuilder
{
    private $doctrine;

    /**
     * HistoryBuilder constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine  = $doctrine;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildHistory(Request $request)
    {
        $bird    = $request->attributes->get('birdId');

        $repository = $this->doctrine->getRepository(Report::class);

        return [
            $repository->findSelectionWithBird(1,'DESC','addedOn',null,$bird),
            $bird,
            $request->attributes->get('species')
        ];
    }
}
