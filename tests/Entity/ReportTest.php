<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 04/09/17
 * Time: 14:07
 */

namespace tests\Entity;

use App\Entity\Report;
use App\Services\Tools;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class ReportTest
 * @package tests\Entity
 */
class ReportTest extends TestCase
{
    public function testReport()
    {
        $report = new Report();
        $satNav = "lat: 48.8627, lng: 150.644";
        $todaySql = date('Y-m-d');
        $comment = "lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        Pellentesque at laoreet nibh. Donec sed metus erat. 
        Pellentesque tristique tortor quis sapien pharetra, 
        id fringilla ante ornare. Proin posuere enim eget lectus condimentum sagittis. Sed metus.";
        $commentToGet = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        Pellentesque at laoreet nibh. Donec sed metus erat. 
        Pellentesque tristique tortor quis sapien pharetra, 
        id fringilla ante ornare. Proin posuere enim eget lectus condimentum sagittis. Sed metus.";

        $report->setLocation('Caen');
        $report->setSatNav($satNav);
        $report->setAddedOn($todaySql);
        $report->setComment($comment);
        $report->setNbrOfBirds(8);
        $report->setValidated(true);
        $report->setValidationScore(5);

        $tools = new Tools();
        $pictName = $tools->generateDataForHomeImg('rosignol',1);
        $report->setPictRef($pictName['fileName']);



        static::assertEquals('Caen', $report->getLocation());
        static::assertEquals('lat: 48.8627, lng: 150.644', $report->getSatNav());
        static::assertEquals(true,($todaySql == $report->getAddedOn()));
        static::assertEquals(true,($commentToGet == $report->getComment()));
        static::assertEquals(8, $report->getNbrOfBirds());
        static::assertEquals(true,$report->getValidated());
        static::assertEquals(5, $report->getValidationScore());
        static::assertEquals($pictName['fileName'],$report->getPictRef());



    }
}