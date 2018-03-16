<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 16/03/2018
 * Time: 13:13
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('smith');
        $user->setSurname('john');
        $user->setEmail('j.smith@gmail.com');
        $user->setCreatedOn('Y-m-d');
        $user->setAccessLevel(3);
        $user->setPswd('Js5789/14');
        $user->setActivated(true);
        $user->setOnHold(false);
        $user->setConfirmationToken(40);
        $user->setBan(false);
        $user->setDeactivated(false);
        $user->setActivated(true);

        $manager->persist($user);
        $manager->flush();

    }
}

