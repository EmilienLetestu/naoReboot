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
            'PHP_AUTH_PW'   => 'password',
        ));


        $client->request('GET','/accueil');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET','/connexion/inscription');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET','/mot-de-passe-oublier');
        $this->assertTrue($client->getResponse()->isSuccessful());

    }
}
