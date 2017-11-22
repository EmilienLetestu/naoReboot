<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 22/11/2017
 * Time: 22:10
 */

namespace App\Builders;


use App\Managers\ReportManager;
use App\Services\HomeImg;

class HomePageBuilder
{
    private $reportManager;
    private $homeImg;

    /**
     * HomePageBuilder constructor.
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
     * @return array
     */
    public function buildHomePage()
    {
        return[
            $this->reportManager->displayHomePageReport(),
            $this->homeImg->getHomeImage()
        ];
    }
}
