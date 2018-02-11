<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 16:40
 */

namespace App\Action;

use App\Entity\Report;
use App\Form\ReportType;
use App\Handler\ReportHandler;
use App\Responder\AddReportResponder;
use App\Services\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AddReportAction
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * @var ReportHandler
     */
    private $reportHandler;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * AddReportAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param ReportHandler $reportHandler
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        ReportHandler          $reportHandler,
        UrlGeneratorInterface  $urlGenerator
    )
    {
        $this->formFactory   = $formFactory;
        $this->doctrine      = $doctrine;
        $this->reportHandler = $reportHandler;
        $this->urlGenerator  = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param AddReportResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AddReportResponder $responder)
    {
        $report = new Report();
        $form = $this->formFactory
                     ->create(ReportType::class, $report)
                     ->handleRequest($request)
        ;

        if($this->reportHandler->handle($form, $report))
        {
            $this->doctrine->getRepository(Report::class);
            $this->doctrine->persist($report);
            $this->doctrine->flush();

            return new RedirectResponse(
                $this->urlGenerator->generate('addReport')
            );
        }

        return $responder($form->createView());
    }
}

