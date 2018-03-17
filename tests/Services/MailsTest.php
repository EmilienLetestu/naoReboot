<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 17/03/2018
 * Time: 11:20
 */

namespace test\Services;

use App\Services\Mails;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class MailsTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var
     */
    private $twig;


    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $this->twig = static::$kernel->getContainer()
            ->get('twig')
        ;
    }

    public function testMails(){
        $mail = new Mails($this->twig, $this->em);

        $availability = $mail->checkMailAvailability('j.smith@gmail.com');
        static::assertEquals(1,count($availability));

        //test mail content
        $token = 'abcdefghijkl';

        $validationMail = $mail->validationMail(
            'john',
            'smith',
            $token,
            'j.smith@gmail.com'
        );
        static::assertArrayHasKey('j.smith@gmail.com', $validationMail->getTo());
        static::assertArrayHasKey('activation@nao.fr', $validationMail->getFrom());

        $resetPswdMail = $mail->resetPswdMail(
            'john',
            'smith',
            $token,
            'j.smith@gmail.com'
        );
        static::assertArrayHasKey('j.smith@gmail.com', $resetPswdMail->getTo());
        static::assertArrayHasKey('admin@nao.fr', $resetPswdMail->getFrom());


        $text = 'sdsqdsqdsqdsqdsqdsqdsqdsd';
        $contactMail = $mail->contactMail(
            'john smith',
            'j.smith@gmail.com',
            null,
            $text
        );
        static::assertArrayHasKey('j.smith@gmail.com', $contactMail->getFrom());
        static::assertArrayHasKey('contact@nao.fr', $contactMail->getTo());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }
}
