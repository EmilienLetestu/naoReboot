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

    }
}