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

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class StarManager
{
    private $doctrine;
    private $token;

    public function __construct(
        EntityManagerInterface $doctrine,
        TokenStorageInterface  $token

    )
    {
        $this->doctrine  = $doctrine;
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

        // if hasn't been stared yet skip verification
        // otherwise check logged user never stared this report before
        $check = $score === 0 ? true : $this->hasAlreadyBeenStared($starList, $loggedId);

        if($check === 'has voted')
        {
           return 'Vous avez déjà ajouter une étoile à cette observation';
        }
        if($loggedId === $report->getUser()->getId())
        {
            return 'Vous ne pouvez pas ajouter d\'étoile à vos observations';
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

        return 'success';
    }

    /**
     * check if a given user as stared a given report
     * @param array $starList
     * @param $loggedId
     * @return bool
     */
    public function hasAlreadyBeenStared($starList, $loggedId)
    {

        foreach ($starList as $star)
        {
            $userList[] = $star->getUser();
        }

        foreach ($userList as $user)
        {
            $idList[] = $user->getId();
        }
        return  in_array($loggedId, $idList) ? 'has voted' : false;
    }
}

