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
        $client = self::createClient();

        $client->request('GET','/');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET','connexion');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET','/connexion/inscription');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET','/mot-de-passe-oublier');
        $this->assertTrue($client->getResponse()->isSuccessful());

    }
}
