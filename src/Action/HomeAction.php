<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/02/2018
 * Time: 09:54
 */

namespace App\Action;

use App\Managers\ReportManager;
use App\Responder\HomeResponder;
use App\Services\HomeImg;

class HomeAction
{
    /**
     * @var ReportManager
     */
    private $reportManager;

    /***
     * @var HomeImg
     */
    private $homeImg;

    /**
     * HomeAction constructor.
     * @param ReportManager $reportManager
     * @param HomeImg $homeImg
     */
    public function __construct(
        ReportManager $reportManager,
        HomeImg       $homeImg
    )
    {
        $this->reportManager = $reportManager;
        $this->homeImg       = $homeImg;
    }

    /**
     * @param HomeResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(HomeResponder $responder)
    {
        return
            $responder(
                $this->reportManager->displayHomePageReport(),
                $this->homeImg->getHomeImage()
            )
        ;
    }
}
