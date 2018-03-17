<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 17/03/2018
 * Time: 20:59
 */

namespace tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class registrationTest extends WebTestCase
{
    public function testRegistration()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','/connexion/inscription');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $form = $crawler->filter("form")->form();

        $form['register[name]'] = 'john';
        $form['register[surname]'] = 'smith';
        $form['register[email]'] = 'j.smith@gmail.com';
        $form['register[pswd]'] ='js1452574/2';
        $form['register[accessLevel]']->select(1);
        $form['register[termsAgreement]']->tick();

        $crawler = $client->submit($form);
        $this->assertSame(1,$crawler->filter('div.alert.alert-denied')->count());
        $this->assertSame(1, $crawler->filter('div.alert.alert-denied:contains("Cette email est déjà utilisé")')->count());

    }
}

