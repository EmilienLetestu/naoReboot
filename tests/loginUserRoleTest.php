<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 17/03/2018
 * Time: 22:11
 */

namespace tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class loginUserRoleTest extends WebTestCase
{
    public function testLoginUserRole()
    {
        $client = static::createClient();

        $crawler = $client->request('GET','/connexion');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());

        $form = $crawler->filter("form")->form();
        $form['_username'] = 'j.smith@gmail.com';
        $form['_password'] = 'js1452574/2';

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('div#backGenerated')->count());

        //continue navigation
        $link = $crawler
            ->filter('a:contains("Observations")')
            ->link()
        ;

        $crawler = $client->click($link);
        $this->assertSame(1,$crawler->filter('h1:contains(OBSERVATIONS)')->count());
    }
}
