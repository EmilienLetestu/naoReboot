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
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ValidationManager
{

    private $doctrine;
    private $session;
    private $token;

    /**
     * ValidationManager constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param TokenStorage $token
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        TokenStorage  $token
    )
    {
        $this->doctrine = $doctrine;
        $this->session  = $session;
        $this->token    = $token;
    }

    /**
     * @param $reportId
     * @return mixed
     */
    public function validationProcess($reportId)
    {
        //fetch matching report
        $repository = $this->doctrine->getRepository(Report::class);
        $report = $repository->find($reportId);
        $score = $report->getValidationScore();

        //get logged user and his id
        $user       = $this->token->getToken()->getUser();
        $loggedId   = $user->getId();
        //get all validation added for this report
        $validationList = $report->getValidations();


        // if hasn't gathered any validation, skip verification
        // otherwise check logged user never validated this report before
        $check = $score === 0 ? true : $this->hasAlreadyBeenValidated($validationList, $loggedId);

        if($check === 'has validated')
        {
            return $this->session->getFlashBag()
                ->add('denied',
                    'Vous avez déjà validé cette observation')
            ;
        }

        //create a new validation object and hydrate it
        $validation = new Validation();
        $validation
            ->setUser($user)
            ->setReport($report)
        ;
        //update report
        $report
            ->addValidation($validation)
            ->setValidationScore($score + 1)
        ;
        //prepare validation to get stored
        $this->doctrine->persist($validation);

        //check if report has to be validated
        //need 5 validations to be validated
        if($score === 4)
        {
            $report->setValidated(true);
            $this->doctrine->persist($report);
            $this->doctrine->flush();
            // ?--- maybe send a notification ---? //
            return $this->session->getFlashBag()
                ->add('success','Validation ajoutée')
            ;
        }

        $this->doctrine->persist($report);
        $this->doctrine->flush();

        return $this->session->getFlashBag()
            ->add('success','Validation ajoutée')
        ;
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

