<?php
/**
 * Created by PhpStorm.
 * User: emilien
 * Date: 04/09/17
 * Time: 15:18
 */

namespace tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class UserTest
 * @package tests\Entity
 */
class UserTest extends TestCase
{
    public function testUser()
    {
        $user = new User();

        $date = new \DateTime(date('Y-m-d'));

        $user->setAccessLevel(1);
        $user->setActivated(true);
        $user->setBan(false);
        $user->setCreatedOn('Y-m-d');
        $user->setConfirmationToken(40);
        $user->setDeactivated(false);
        $user->setEmail('user@gmail.com');
        $user->setPswd('Us/1278');
        $user->setOnHold(false);
        $user->setName("<p>eMiliEn</p>");
        $user->setSurname("<a href='mywebsite.com'>LeTestU</a>");

        static::assertEquals(1, $user->getAccessLevel());
        static::assertEquals(true, $user->getActivated());
        static::assertEquals(false, $user->getBan());
        static::assertEquals($date,$user->getCreatedOn());
        static::assertEquals(40, strlen($user->getConfirmationToken()));
        static::assertEquals(0, $user->getDeactivated());
        static::assertEquals('user@gmail.com', $user->getEmail());
        static::assertNotEquals('Us/1278', $user->getPswd());
        static::assertEquals('Emilien', $user->getName());
        static::assertEquals('Letestu', $user->getSurname());

        $role = $user->getRoles();
        $notLocked = $user->isAccountNonLocked();
        $enable    = $user->isEnabled();

        static::assertEquals('ROLE_USER',$role[0]);
        static::assertEquals(false, 'ROLE_VALIDATOR' == $role[0]);
        static::assertEquals(true,$notLocked);
        static::assertEquals(true, $user->getActivated()===$enable);
    }
}
