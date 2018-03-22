<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 28/09/17
 * Time: 22:09
 */
namespace tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class routingAnonymousTest extends WebTestCase
{


    public function testAnonymousRouting()
    {
        $client = static::createClient();


        $client->request('GET','/');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $client->request('GET','/conditions-generales-d-utilisation');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $client->request('GET','/connexion/inscription');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $client->request('GET','/mot-de-passe-oublier');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $client->request('GET','/nao-et-ses-partenaires');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $client->request('GET','/observations/valide');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());

        $client->request('GET','/observations/en-attente-de-validation');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());

        $client->request('GET','/observations/nouvelle-observation');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());

        $client->request('GET','/historique-des-observations/some-species-name/1');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());

        $client->request('GET','/admin');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());

        $client->request('GET','/admin/comptes-inactifs');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());

        $client->request('GET','/admin/liste-des-especes');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());

        $client->request('GET','/admin/demande-acces-naturaliste');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());

    }
}

