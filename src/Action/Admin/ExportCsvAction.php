<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 10:17
 */

namespace App\Action\Admin;

use App\Entity\Report;
use App\Responder\Admin\ExportCsvResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Serializer\Serializer;


class ExportCsvAction
{
    private $serializer;
    private $doctrine;

    public function __construct(
        Serializer    $serializer,
        EntityManagerInterface $doctrine
    )
    {
        $this->serializer = $serializer;
        $this->doctrine   = $doctrine;
    }

    public function __invoke(ExportCsvResponder $responder)
    {
        $data = $this->doctrine
            ->getRepository(Report::class)
            ->findAll()
        ;

        foreach ( $data as $report){
            $reportList[]=[
                'id'     => $report->getId(),
                'espece' => $report->getBird()->getSpeciesNameOnly(),
                'nbre'   => $report->getNbrOfBirds(),
                'date'   => $report->getAddedOn()->format('d/m/Y'),
                'lieu'   => $report->getLocation(),
                'gps'    => $report->getSatNav()
            ];
        }

        $fileContent = $this->serializer->encode($reportList,'csv');

        return $responder($fileContent);
    }

}
