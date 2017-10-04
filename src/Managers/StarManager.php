<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 28/09/17
 * Time: 12:06
 */

namespace App\Managers;

use App\Entity\Report;
use App\Entity\Star;

use App\Services\Tools;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class StarManager
{
    private $doctrine;
    private $session;
    private $tools;
    private $token;

    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        Tools         $tools,
        TokenStorage  $token

    )
    {
        $this->doctrine  = $doctrine;
        $this->session   = $session;
        $this->tools     = $tools;
        $this->token     = $token;
    }

    /**
     *
     * @param $reportId
     * @return mixed
     */
    public function starProcess($reportId)
    {

        //fetch matching Report
        $repository = $this->doctrine->getRepository(Report::class);
        $report = $repository->find($reportId);
        $score  = $report->getStarNbr();

        //get logged user and his id
        $user     = $this->token->getToken()->getUser();
        $loggedId = $user->getId();
        //get all stars added for this report
        $starList = $report->getStars();

        //check logged user never stared this report before
        $check = $this->hasAlreadyBeenStared($starList, $loggedId);

        if( $check === true)
        {
           return $this->session->getFlashBag()
               ->add('denied',
                     'Vous avez déjà ajouter une étoile à cette observation')
            ;
        }
        //create a new star object and hydrate it
        $star = new Star();
        $star
        ->setUser($user)
        ->setReport($report)
        ;
        //update report with new data
        $report
            ->addStar($star)
            ->setStarNbr($score+1)
            ->addStar($star)
        ;
        //store new star into db
        $this->doctrine->getRepository(Star::class);
        $this->doctrine->persist($star);
        $this->doctrine->persist($report);
        $this->doctrine->flush();

        // !! remenber to update session var 'star' if ever it's used later on !! //

        return $this->session->getFlashBag()
            ->add('success','Etoile ajouteé')
        ;
    }

    /**
     * check if a given user as stared a given report
     * @param array $starList
     * @param $loggedId
     * @return bool
     */
    public function hasAlreadyBeenStared($starList, $loggedId)
    {
        if($starList === null)
        {
            return false;
        }

        foreach ($starList as $star)
        {
            $userList[] = $star->getUser();
            foreach ($userList as $user)
            {
                $idList[] = $user->getId();
            }
        }

        return  in_array($loggedId, $idList) ? true : false;
    }
}