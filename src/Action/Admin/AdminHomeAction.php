<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/02/2018
 * Time: 10:40
 */

namespace App\Action\Admin;


use App\Entity\Report;
use App\Entity\User;
use App\Form\Type\UpdateHomeType;
use App\Handler\UpdateHomeHandler;
use App\Responder\Admin\AdminHomeResponder;
use App\Services\HomeImg;
use App\Services\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminHomeAction
{
    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * @var HomeImg
     */
    private $homeImg;

    /**
     * @var UpdateHomeHandler
     */
    private $updateHomeHandler;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Tools
     */
    private $tools;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * AdminHomeAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param HomeImg $homeImg
     * @param UpdateHomeHandler $updateHomeHandler
     * @param FormFactoryInterface $formFactory
     * @param Tools $tools
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        HomeImg                $homeImg,
        UpdateHomeHandler      $updateHomeHandler,
        FormFactoryInterface   $formFactory,
        Tools                  $tools,
        UrlGeneratorInterface  $urlGenerator

    )
    {
        $this->doctrine          = $doctrine;
        $this->homeImg           = $homeImg;
        $this->updateHomeHandler = $updateHomeHandler;
        $this->formFactory       = $formFactory;
        $this->tools             = $tools;
        $this->urlGenerator      = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param AdminHomeResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminHomeResponder $responder)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $repoReport = $this->doctrine->getRepository(Report::class);

        $form = $this->formFactory
                     ->create(UpdateHomeType::class)
                     ->handleRequest($request)
        ;

        $diff = $this->tools->getTimeElapsed();

        //total
        $totalReport = count(
            $repoReport->countAllValidated()
        );
        $totalUser = count(
            $repository->countAllActivated()
        );

        // reference values for user based stats
        $allReportByUserLevel2 = count(
            $repoReport->countWithUserAccessLevel(1)
        );
        $allReportByUserLevel1 = count(
            $repoReport->countWithLowerAccessLevel()
        );

        if($this->updateHomeHandler->handle($form))
        {
            return new RedirectResponse(
                $this->urlGenerator->generate('admin')
            );
        }

        return $responder(
            $totalReport,
            count($repoReport->countValidatedThisMonth(date('Y'),date('m'))),
            count($repoReport->countValidatedThisYear(date('Y'))),
            $totalReport / $diff['days'],
            $totalReport / $diff['months'],
            $totalReport / $totalUser,
            $allReportByUserLevel1,
            $allReportByUserLevel2,
            $allReportByUserLevel1 > 0 ? $totalReport / $allReportByUserLevel1 : 0,
            $allReportByUserLevel2 > 0 ? $totalReport / $allReportByUserLevel2 : 0,
            $this->homeImg->getHomeImage(),
            $form->createView(),
            'Espace d\'administration'
        );
    }

}
