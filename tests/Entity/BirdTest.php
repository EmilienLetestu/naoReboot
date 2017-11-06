<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 04/09/17
 * Time: 16:13
 */

namespace tests\Entity;

use App\Entity\Bird;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class BirdTest
 * @package tests\Entity
 */
class BirdTest extends TestCase
{
    public function testBird()
    {
        $bird = new Bird();

        $bird->setSpeciesLatin('Accelerati Incredibilus');
        $bird->setSynonymous('Speedipus Rex');
        $bird->setSpeciesFr('Beep Beep');
        $bird->setBreed('Disappearialis Quickius');
        $bird->setBirdGroup('Road Runnerus');

        static::assertEquals('Accelerati Incredibilus', $bird->getSpeciesLatin());
        static::assertEquals('Speedipus Rex', $bird->getSynonymous());
        static::assertEquals('Beep Beep', $bird->getSpeciesFr());
        static::assertEquals('Disappearialis Quickius', $bird->getBreed());
        static::assertEquals('Road Runnerus', $bird->getBirdGroup());
    }
}
