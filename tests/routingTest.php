<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 28/09/17
 * Time: 22:09
 */
namespace tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class routingTest extends WebTestCase
{
    public function testRouting()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'username',
            'PHP_AUTH_PW'   => 'pa$$word',
        ));




        $crawler = $client->request('GET','/connexion');
        $this->assertTrue($crawler->filter('html:contains("Email")')->count() > 0);



    }
}
