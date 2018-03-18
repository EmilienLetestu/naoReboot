<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 17/03/2018
 * Time: 22:11
 */

namespace tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class navigationAndRoleTest extends WebTestCase
{
    /**
     * @var
     */
    private $client;


    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testUserRole()
    {
        $crawler = $this->login('j.smith@gmail.com','js1452574/2');
        $this->assertSame(1, $crawler->filter('div#backGenerated')->count());


        //check navigation menu content match "user" role
        $this->assertSame(6, $crawler->filter('#dashboard ul li')->count());
        $this->assertSame(0, $crawler->filter('a:contains("En attente de validation")')->count());
        $this->assertSame(0, $crawler->filter('a:contains("Espace d\'administration")')->count());


        //continue navigation
        $link = $crawler
            ->filter('a:contains("Observations")')
            ->link()
        ;

        $crawler = $this->client->click($link);
        $this->assertSame(1,$crawler->filter('h1:contains(OBSERVATIONS)')->count());

        $this->logout();
    }

    public function testValidatorRole(){

        $crawler = $this->login('daniel.letestu@orange.fr','Jd180199');

        $this->assertSame(1, $crawler->filter('div#backGenerated')->count());

        //check navigation menu content match "validator" role
        $this->assertSame(7, $crawler->filter('#dashboard ul li')->count());
        $this->assertSame(1, $crawler->filter('a:contains("En attente de validation")')->count());
        $this->assertSame(0, $crawler->filter('a:contains("Espace d\'administration")')->count());

        //continue navigation
        $link = $crawler
            ->filter('a:contains("En attente de validation")')
            ->link()
        ;

        $crawler = $this->client->click($link);
        $this->assertSame(1,$crawler->filter('h1:contains(OBSERVATIONS EN ATTENTES DE VALIDATION)')->count());

        $this->logout();
    }

    public function testAdminRole(){

        $crawler = $this->login('eletestu@gmail.com','adminTest19');
        $this->assertSame(1, $crawler->filter('div#backGenerated')->count());

        //check navigation menu content match "admin" role
        $this->assertSame(8, $crawler->filter('#dashboard ul li')->count());
        $this->assertSame(1, $crawler->filter('a:contains("En attente de validation")')->count());
        $this->assertSame(1, $crawler->filter('a:contains("Espace d\'administration")')->count());

        $crawler = $this->client->request('GET','/admin/liste-des-membres');
        $this->assertSame(1, $crawler->filter('h1:contains("LISTE DES MEMBRES")')->count());
        $this->assertSame(1, $crawler->filter('#adminNavTrigger')->count());

        $link = $crawler
            ->filter('a:contains("Liste des espèces")')
            ->link()
        ;

        $crawler = $this->client->click($link);
        $this->assertSame(1, $crawler->filter('h1:contains(LISTE DES ESPECES)')->count());

        $this->logout();
    }

    /**
     * @param $username
     * @param $pswd
     * @return mixed
     */
    private function login($username, $pswd){

        $crawler = $this->client->request('GET','/connexion');
        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());
        $form = $crawler->filter("form")->form();
        $form['_username'] =  $username;
        $form['_password'] =  $pswd;
        $this->client->submit($form);

        return $this->client->followRedirect();
    }

    private function logout(){
        return $this->client->request('GET','/logout');
    }
}
