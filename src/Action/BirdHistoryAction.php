<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 11:58
 */

namespace App\Action;



use App\Entity\Report;
use App\Responder\BirdHistoryResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class BirdHistoryAction
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function __invoke(Request $request, BirdHistoryResponder $responder)
    {
      $repository = $this->doctrine->getRepository(Report::class);
      return
          $responder(
              $bird = $request->attributes->get('birdId'),
              $repository->findSelectionWithBird(1,'DESC','addedOn',null,$bird),
              $request->attributes->get('species')
          );
    }
}