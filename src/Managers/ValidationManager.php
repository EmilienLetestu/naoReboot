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
use App\Services\Tools;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class ValidationManager
{

    private $doctrine;

    private $session;

    private $tools;

    /**
     * ValidationManager constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param Tools $tools
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        Tools         $tools
    )
    {
        $this->doctrine = $doctrine;
        $this->session  = $session;
        $this->tools    = $tools;
    }

    /**
     * @param $reportId
     */
    public function storeValidation($reportId)
    {
        //fetch matching report and add one to score
        $repository = $this->doctrine->getRepository(Report::class);
        $report = $repository->find($reportId);
        $score = $report->getValidationScore();

        //---  will get user data from session as soon as session bug will be fixed ---//

        //create a new validation object and hydrate it
        $validation = new Validation();
        $validation
            ->setUser($user) // fetch $user from sesssion
            ->setReport($report)
        ;

        //update report with new data
        $report
            ->addValidation($validation)
            ->setValidationScore($score + 1);

        $this->doctrine->persist($validation);

        //check if report as to be validated
        //need 5 validations to be validated
        if($score === 4)
        {
            $this->doctrine->persist(
                $report->setValidated(true)
            );
            $this->doctrine->flush();
        }

        $this->doctrine->flush();
    }
}