<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 28/09/17
 * Time: 11:23
 */

namespace App\Managers;

use App\Entity\Report;
use App\Entity\Validation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ValidationManager
{

    private $doctrine;
    private $token;
    private $notification;

    /**
     * ValidationManager constructor.
     * @param EntityManagerInterface $doctrine
     * @param TokenStorageInterface $token
     * @param NotificationManager $notification
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        TokenStorageInterface  $token,
        NotificationManager    $notification

    )
    {
        $this->doctrine     = $doctrine;
        $this->token        = $token;
        $this->notification = $notification;
    }

    /**
     * @param $reportId
     * @return mixed
     */
    public function validationProcess($reportId)
    {
        $repository = $this->doctrine->getRepository(Report::class);
        $report = $repository->find($reportId);
        $score = $report->getValidationScore();

        //get logged user and his id
        $user       = $this->token->getToken()->getUser();
        $loggedId   = $user->getId();
        $validationList = $report->getValidations();

        // if hasn't gathered any validation, skip verification
        // otherwise check logged user never validated this report before
        $check = $score === 0 ? true : $this->hasAlreadyBeenValidated($validationList, $loggedId);

        if($check === 'has validated')
        {
            return 'Vous avez déjà validé cette observation';
        }

        $validation = new Validation();
        $validation
            ->setUser($user)
            ->setReport($report)
        ;

        $report
            ->addValidation($validation)
            ->setValidationScore($score + 1)
        ;

        $this->doctrine->persist($validation);

        //check if report has to be validated
        //need 5 validations to be validated
        if($score === 4)
        {
            $this->notification->notifyUser(5,
                $report->getUser()
            );
            $report->setValidated(true);
        }

        $this->doctrine->persist($report);
        $this->doctrine->flush();

        return 'success';
    }

    /**
     * check if a given user as stared a given report
     * @param $validationList
     * @param $loggedId
     * @return bool
     */
    public function hasAlreadyBeenValidated($validationList,$loggedId)
    {
        if($validationList === null)
        {
            return false;
        }
        foreach ($validationList as $validation)
        {
            $userList[] = $validation->getUser();
        }

        foreach ($userList as $user)
        {
            $idList[] = $user->getId();
        }

        return in_array($loggedId, $idList) ? 'has validated' : false;
    }
}

