<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 27/11/2017
 * Time: 14:15
 */

namespace App\Services;



use App\Entity\Report;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Serializer\Serializer;

class ExportCsv
{
    private $serializer;
    private $doctrine;

    public function __construct(
        Serializer    $serializer,
        EntityManager $doctrine
    )
    {
        $this->serializer = $serializer;
        $this->doctrine   = $doctrine;
    }

    public function encodeTable()
    {

        $repository = $this->doctrine->getRepository(Report::class);
        $data = $repository->findAll();

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

        $filename = 'data.csv';

        $fileContent = $this->serializer->encode($reportList,'csv');

        $response = new Response( str_replace(',', ';', $fileContent));

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

}