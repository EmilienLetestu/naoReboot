<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 27/09/17
 * Time: 08:50
 */
namespace test\Services;

use App\Services\Tools;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class ToolsTest extends TestCase
{
    public function testTools()
    {
        $tools = new Tools();


        $stillValidFalse = $tools->isLinkStillValid('2017-07-02');
        $stillValidTrue = $tools->isLinkStillValid(date('Y-m-d'));

        static::assertEquals(false,$stillValidFalse);
        static::assertEquals(true,$stillValidTrue);


        $onHoldFalse = $tools->getUserAccountStatus(1);
        $onHoldTrue  = $tools->getUserAccountStatus(2);

        static::assertEquals(false,$onHoldFalse);
        static::assertEquals(true,$onHoldTrue);


        $homePageImgData = $tools->generateDataForHomeImg('rossignol',1);

        static::assertInternalType('array',$homePageImgData);
        static::assertEquals('rossignol',$homePageImgData['watermark']);
        static::assertEquals('nao recherche: rossignol',$homePageImgData['altText']);
        static::assertEquals('naoEvent_1_rossignol', $homePageImgData['fileName']);


        $speciesLatin = 'Accipiter fasciatus vigilax (Wetmore, 1926)';
        $speciesFr    = 'Autour australien, Émouchet gris';
        $wiki = $tools->birdWiki($speciesLatin,$speciesFr);

        static::assertInternalType('array',$wiki);
        static::assertEquals('Accipiter fasciatus vigilax', $wiki['latin']);
        static::assertEquals('Wetmore', $wiki['twitcher']);
        static::assertEquals('1926', $wiki['year']);
        static::assertEquals('Autour australien', $wiki['fr']);


        $userImgData = $tools->generateDataForUserImg('rossignol',1);

        static::assertInternalType('array', $userImgData);
        static::assertEquals('observation de rossignol sur NAO.fr', $userImgData['altText']);

    }
}
